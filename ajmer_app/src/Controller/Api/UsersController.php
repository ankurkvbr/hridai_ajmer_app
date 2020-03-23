<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
		$this->loadModel('Tokens');
		$this->loadModel('Saltkeys');
        $this->Auth->allow(['login', 'register', 'forgotPassword', 'logout', 'getSaltKey']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => ['Roles']
                ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }
	
	public function getSaltKey() {
		
		if(isset($this->request->data['device_id'])){
			$device_id = $this->request->data['device_id'];	
			$salt = bin2hex(mcrypt_create_iv(8, MCRYPT_DEV_URANDOM));
		}
		//$salt = rand(19999, 29999);
		$saltsDevice = $this->Saltkeys->find('all')->where(['device_id' => $device_id])->first();
		
		if(!empty($saltsDevice)) {
			if($this->Saltkeys->updateAll(['salt' => $salt,'created_at' => date("Y-m-d H:i:s")], ['device_id' => $device_id])) {
				
				$this->set([
					'_resultflag' => true,
					'message' => __('salt has been generated successfully'),
					'salt' => $salt
				]);	
				$this->set(compact('_resultflag', 'message', 'salt'));
				$this->set('_serialize', ['_resultflag', 'message', 'salt']);
			} else{
				$this->set([
					'_resultflag' => false,
					'message' => __('salt could not be generated. Please, try again'),
				]);
				$this->set(compact('_resultflag', 'message'));
				$this->set('_serialize', ['_resultflag', 'message']);
			}
		} else {
			$saltkeys = $this->Saltkeys->newEntity();
			$saltkeys = $this->Saltkeys->patchEntity($saltkeys, [
				'device_id' => $device_id,
				'salt' => $salt,
				'created_at' => date("Y-m-d H:i:s"),
				]
			);
			if ($this->Saltkeys->save($saltkeys)) {
				$this->set([
					'_resultflag' => true,
					'message' => __('salt has been generated successfully'),
					'salt' => $salt
				]);
				$this->set(compact('_resultflag', 'message', 'salt'));
				$this->set('_serialize', ['_resultflag', 'message', 'salt']);
			} else{
				$this->set([
					'_resultflag' => false,
					'message' => __('salt could not be generated. Please, try again'),
				]);
				$this->set(compact('_resultflag','message'));
				$this->set('_serialize', ['_resultflag','message']);
			}
		}
	}
	
    public function register() {

        $this->request->allowMethod(['post']);
        
		$error = [];
        $generate_rand_token = uniqid(rand(10,10));
		
		$this->request->data['dob'] = (isset($this->request->data['dob'])) ? date('Y-m-d', strtotime($this->request->data['dob'])) : '0000-00-00';
		if(isset($this->request->data['device_id'])){
			$device_id = $this->request->data['device_id'];	
		}
		
		if(isset($this->request->data['password'])){
			$device_id 		 = isset($this->request->data['device_id']) ? $this->request->data['device_id'] : '';
			$saltEncryptPass = $this->request->data['password'];
			$removeSaltPass  = substr($saltEncryptPass, -16);
			$saltsDevice 	 = $this->Saltkeys->find('all')->where(['device_id' => $device_id])->first();
			if(!empty($saltsDevice)) {	
				$salt = $saltsDevice->salt;
				if($removeSaltPass == $salt){
					$encryptPass  	 = str_replace($removeSaltPass,"",$saltEncryptPass);
					$decryptPass     = $this->CryptAes->passDecrypt($encryptPass, $device_id);
					$this->request->data['password'] = md5($decryptPass);
					if ($this->Saltkeys->delete($saltsDevice)) 
					{
						$this->set([
							'_resultflag' => true
						]);	
					} else{
						$this->set([
							'_resultflag' => false
						]);
					}			
				} else{
					$this->set([
					'_resultflag' => false,
					'message' => __('Problem error with registeration, Please check password'),
					]);
					$this->set(compact('_resultflag','message'));
					$this->set('_serialize', ['_resultflag','message']);
				}
			}
		}
		
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
			
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->registration_date = date('Y-m-d H:i:s');
            $user->role_id = 2;
			
            $email = $this->request->data['email'];//str_replace('%40', '@', $this->request->data['email']);
            $userchk = $this->Users->find('all')->where(['email = ' => $email]);
            $asuser = $userchk->toArray();

            if(!empty($asuser)){
                    $_resultflag = false;
                    $message = __('Email already exist.');
                    $this->set([
                        '_resultflag' => true,
                        'message' => $message,
                        'user' => [],
                        '_serialize' => ['_resultflag', 'message']
                    ]);
            } else{
                if ($this->Users->save($user)) {
					
					$encRandomToken = $this->CryptAes->encryption($user['id'], $device_id, $generate_rand_token);

					$tokens = $this->Tokens->newEntity();
					$tokens = $this->Tokens->patchEntity($tokens, [
						'user_id' => $user['id'],
						'device_id' => $device_id,
						'token' => $generate_rand_token
						]
					);
					
					if ($this->Tokens->save($tokens)) {
						$user->set([
							'rand_token' => $encRandomToken
						]);
						$this->set([
						'_resultflag' => true,
						'message' => __("User registered successfully."),
						'user' => $user,
						'_serialize' => ['_resultflag', 'message', 'user']
						]);
					} else {
						$this->set([
						'_resultsave' => false,
						'messagesave' => __('The token could not be saved. Please, try again.'),
						'_serialize' => ['_resultsave', 'messagesave']
						]);
					}
                } else {
                    $error = $user->errors();
                    foreach($error as $key => $er){
                        if($key == 'email'){
                            $message = 'Provided email address is invalid';
                        }else{
                            $message = $key.' : '.$er[$key];
                        }
                    }

                    $_resultflag = false;
                    //$message = __('System error occurred, please try again.');
                    $this->set([
                        '_resultflag' => false,
                        'message' => $message,
                        'user' => [],
                        '_serialize' => ['_resultflag', 'message']
                    ]);
                }
            }
        }
        $this->set(compact('_resultflag', 'message', '_resultsave', 'messagesave', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit() {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => []
                ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            //$user->updated_by = $this->Auth->user('id');
            $user->updated_date = date('Y-m-d H:i:s');
            if ($this->Users->save($user)) {
                $_resultflag = true;
                $message = __('User edit successfully.');
            } else {
                $_resultflag = false;
                $message = __('System error occurred, please try again.');
            }
        }
        //$roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('_resultflag', 'message', 'user'));
        $this->set('_serialize', ['_resultflag', 'message', 'user']);
    }

    public function changePassword() {

        $user = $this->Users->newEntity();
        $_resultflag = false;
        $message = '';
        if ($this->request->is(['post'])) {
            $user = $this->Users->get($this->Auth->user('id'));
            $user = $this->Users->patchEntity($user, [
                //'email' => $this->request->data['email'],
                'current_password' => $this->request->data['current_password'],
                'password' => $this->request->data['password'],
                'confirm_password' => $this->request->data['confirm_password']
                    ], ['validate' => 'changePassword']);
            if ($this->Users->save($user)) {
                $_resultflag = true;
                $message = __('Your password has been changed successfully');
            } else {
                $_resultflag = false;
                $message = __('The password could not be changed. Please, try again.');
            }
        }
        $this->set(compact('_resultflag', 'message', 'user'));
        $this->set('_serialize', ['_resultflag', 'message', 'user']);
    }

    /**
     * Login method
     *
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function login() {
        
		$this->request->allowMethod(['post']);
		
        $generate_rand_token = uniqid(rand(10,10));
		if(isset($this->request->data['device_id'])){
			$device_id = $this->request->data['device_id'];	
		}

		if(isset($this->request->data['password'])){
			$device_id 		 = isset($this->request->data['device_id']) ? $this->request->data['device_id'] : '';
			$saltEncryptPass = $this->request->data['password'];
			$removeSaltPass  = substr($saltEncryptPass, -16);
			$saltsDevice 	 = $this->Saltkeys->find('all')->where(['device_id' => $device_id])->first();
			if(!empty($saltsDevice)) {	
				$salt = $saltsDevice->salt;
				if($removeSaltPass == $salt){
					$encryptPass  	 = str_replace($removeSaltPass,"",$saltEncryptPass);
					$decryptPass     = $this->CryptAes->passDecrypt($encryptPass, $device_id);
					$this->request->data['password'] = md5($decryptPass);
					if ($this->Saltkeys->delete($saltsDevice)) 
					{
						$this->set([
							'_resultflag' => true
						]);	
					} else{
						$this->set([
							'_resultflag' => false
						]);
					}					
				} else{
					$this->set([
					'_resultflag' => false,
					'message' => __('Password not matched, Please try again'),
					]);
					$this->set(compact('_resultflag','message'));
					$this->set('_serialize', ['_resultflag','message']);
				}
			}
		}
		
        if($this->request->data('social_flag') != 0){
            
            $social_flag = $this->request->data['social_flag'];
            $social_id = $this->request->data['social_id'];
            
            $userchk = $this->Users->find('all')->where(['social_id = ' => $social_id , 'social_flag =' => $social_flag]);
            
                if(!empty($asuser)){
                $userbyid = $this->Users->get($asuser[0]->id);
                $this->Auth->setUser($userbyid);
				$encRandomToken = $this->CryptAes->encryption($userbyid['id'], $device_id, $generate_rand_token);
                $this->set([
                    '_resultflag' => true,                    
                    'message' => __("Login Successfully."),
                    'rand_token' => $encRandomToken,
                    'user' => $userbyid,
                    '_serialize' => ['_resultflag', 'message', 'rand_token', 'user']
                ]);

            } else{
                $this->set([
                    '_resultflag' => true,
                    'isToRegister' => true,
                    'message' => __("User not registered from social network"),
                    '_serialize' => ['_resultflag', 'isToRegister']
                ]);                            
			}
        } else{
        
            $user = $this->Auth->identify();
			if (!$user) {

				//throw new UnauthorizedException('Invalid username or password');
				$this->set([
					'_resultflag' => false,
					'message' => __("Invalid Username and Password"),
					'user' => [],
					'_serialize' => ['_resultflag', 'message']
				]);
			} else {
				
				$userDevice = $this->Tokens->find('all')->where(['user_id = ' => $user['id'], 'device_id =' => $device_id]);
				$asdevice = $userDevice->toArray();	
				if(empty($asdevice)) {
					$encRandomToken = $this->CryptAes->encryption($user['id'], $device_id, $generate_rand_token);
					
					$tokens = $this->Tokens->newEntity();
					$tokens = $this->Tokens->patchEntity($tokens, [
						'user_id' => $user['id'],
						'device_id' => $device_id,
						'token' => $generate_rand_token
						]
					);
					
					if ($this->Tokens->save($tokens)) {
						$user['rand_token']= $encRandomToken;
						$this->set([
						'_resultflag' => true,
						'message' => __("Login Successfully."),
						'user' => $user,
						'_serialize' => ['_resultflag', 'message', 'user']
						]);

					} else {
						$this->set([
						'_resultsave' => false,
						'messagesave' => __('The token could not be saved. Please, try again.'),
						'_serialize' => ['_resultsave', 'messagesave']
						]);
					}
				} else {
					
					$encRandomToken = $this->CryptAes->encryption($user['id'], $device_id, $asdevice[0]->token);
					$user['rand_token']= $encRandomToken;
					$this->set([
						'_resultflag' => true,
						'message' => __("Login Successfully."),
						'user' => $user,
						'_serialize' => ['_resultflag', 'message', 'user']
					]);
				}
			}        
		}   
		$this->set(compact('_resultflag', 'message', 'user', '_resultsave', 'messagesave'));

    }
    /**
     * ForgotPassword method
     *
     */
    public function forgotpassword() {
        $this->request->allowMethod(['post']);
        if ($this->request->is('post')) {
            if (!empty($this->request->data('email'))) {
                $email = $this->request->data('email');
                $User = $this->Users->findByEmail($email)->first();
                if ($User) {
                    $User->fp_token = Text::uuid();
                    $User->fp_token_at = date('Y-m-d H:i:s');
                    if ($this->Users->save($User)) {
                        //Email 
                        $emailData = [
                            'helpers' => ['Html'],
                            'template' => 'forgotpassword',
                            'emailFormat' => 'html',
                            'to' => trim($User->email),
                            'subject' => __('Please reset your password'),
                            'viewVars' => ['user' => $User]
                        ];
                        $this->Email->send($emailData);
                        $_resultflag = true;
                        $message = __('Password reset instructions have been sent to your email address. You have 24 hours to complete the request.');
                    } else {
                        $_resultflag = false;
                        $message = __('Email not send successfully, try again');
                    }
                } else {
                    $_resultflag = false;
                    $message = __('Invalid email, try again');
                }
            } else {
                $_resultflag = false;
                $message = __('Please enter email');
            }
        }
        $this->set(compact('_resultflag', 'message'));
        $this->set('_serialize', ['_resultflag', 'message']);
    }

    /* for view user profile */

    public function myprofile() {
        $this->request->allowMethod(['get']);
        $user_id = $this->Auth->user('id');
        if (!empty($user_id)) {
            $user = $this->Users->get($user_id, [
                'contain' => ['Roles']
                    ]);
            $this->set('user', $user);
            $this->set('_serialize', ['user']);
            $_resultflag = true;
            $message = __('Success');
        } else {
            $_resultflag = false;
            $message = __('sorry');
        }
        $this->set(compact('_resultflag', 'message'));
    }

    public function editprofile() {
        $user = $this->Users->findByEmail($this->request->data['email'])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            //   $this->request->data['dob'] = (isset($this->request->data['dob']))? date('Y-m-d',strtotime($this->request->data['dob'])) : '0000-00-00';
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->updated_by = $this->Auth->user('email');
            $user->updated_date = date('Y-m-d H:i:s');
            if ($this->Users->save($user)) {

                $_resultflag = true;
                $message = __('success');
            } else {
                $_resultflag = false;
                $message = __('Invalid');
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user', '_resultflag', 'message']);
    }
	
	public function logout() {
		
		$this->request->allowMethod(['post', 'delete']);
		
        if ($this->request->is('post')) {
			$param_token = isset($this->request->data['rand_token'])?$this->request->data['rand_token']:'';
			$decRandomToken = $this->CryptAes->decryption($param_token);
			
			if($decRandomToken){
				
				extract($decRandomToken);
				$userDevice = $this->Tokens->find('all')->where(['user_id = ' => $uid, 'device_id =' => $device_id])->first();
				if(!empty($userDevice))
				{
					if ($this->Tokens->delete($userDevice)) {
						$_resultflag = true;
						$message = __('Logout Successfully!!');
					} else {
						$_resultflag = false;
						$message = __('Invalid user id');
					}
				} else{
						$_resultflag = false;
						$message = __('Invalid token, Please try again !!');
				}
			} else {
				$_resultflag = false;
				$message = __('Invalid token, Please try again !!');
			}	
		}
		$this->set(compact('_resultflag', 'message'));
	}
}
