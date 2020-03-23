<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Utility\Text;
use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Validation\Validator;
use Cake\I18n\Time;
use Cake\Cache\Cache;
use Cake\Event\Event;
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
     * @return void
     */
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['login', 'jcryption', 'forgotPassword', 'resetPassword']);
		$path = substr_replace(WWW_ROOT, "", -8);
        require_once($path . 'vendor' . DS  .'jcryption'. DS . 'JCryption' . DS . '' . 'JCryption.php');
    }
	
	public function jcryption(){
        $this->autoRender = false;
		$path = substr_replace(WWW_ROOT, "", -8);
		$pub = $path . DS. 'vendor'.DS. 'jcryption' . DS . 'JCryption'. DS .'rsa_1024_pub.pem';
		$priv = $path . DS. 'vendor'.DS. 'jcryption' . DS . 'JCryption'. DS .'rsa_1024_priv.pem';
		//$jc = new \JCryption;
        $jc = new \JCryption($pub, $priv);
		$jc->go();
        header('Content-type: text/plain');
    }
	
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
        if (in_array($this->request->action, ['jcryption'])) {
            $this->eventManager()->off($this->Csrf);
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Roles', 'States', 'Cities']
        ];
        $this->paginate = array(
            'limit' => Configure::read('page.limit'),
        );
        if (!empty($this->request->query['search'])) {
            $this->paginate['conditions']['OR'] = ['Users.first_name LIKE' => '%' . trim($this->request->query['search']) . '%', 'Users.last_name LIKE' => '%' . trim($this->request->query['search']) . '%'];
        }
        if (!empty($this->request->query['search_email'])) {
            $this->paginate['conditions'][]['AND'] = ['Users.email LIKE' => '%' . trim($this->request->query['search_email']) . '%'];
        }
        if (!empty($this->request->query['search_mobile'])) {
            $this->paginate['conditions'][]['AND'] = ['Users.mobile_no LIKE' => trim($this->request->query['search_mobile'])];
        }

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
            'contain' => ['Roles', 'States', 'Cities']
                ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
			
			\JCryption::decrypt();
			$this->request->data  = $_REQUEST;
            $data = $this->request->data;
			
			if(isset($data['dob']) && !empty($data['dob'])){
				$dob = explode("/", $data['dob']);
				$dob1 = $dob[2] . '/' . $dob[1] . '/' . $dob[0];
				$data['dob'] = $dob1;	
			}

            $user = $this->Users->patchEntity($user, $data);
            $user->registration_date = date('Y-m-d H:i:s');            
            $user->role_id = 2;
            if ($this->Users->save($user)) {

                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->loadModel('States');

        $states = $this->States->find('list', ['limit' => 200])->order(['States.name'=>'ASC']);
        $citys = $this->States->Cities->find('list', ['limit' => 200]);

        $this->set(compact('user', 'roles', 'states', 'citys'));
        $this->set('_serialize', ['user', 'citys']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {

        $user = $this->Users->get($id, [
            'contain' => []
                ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
			\JCryption::decrypt();
			$this->request->data  = $_REQUEST;
            $data = $this->request->data;
			if(isset($data['dob']) && !empty($data['dob'])){
				$dob = explode("/", $data['dob']);
				$dob1 = $dob[2] . '/' . $dob[1] . '/' . $dob[0];
				$data['dob'] = $dob1;	
			}
            $user = $this->Users->patchEntity($user, $data);
            $user->updated_by = $this->Auth->user('id');
            $user->updated_date = date('Y-m-d H:i:s');
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->loadModel('States');

        $states = $this->States->find('list', ['limit' => 200])->order(['States.name'=>'ASC']);
        $citys = $this->States->Cities->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles', 'states', 'citys'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
    /**
     * Login method
     *
     */
    public function login() {
		
        $this->viewBuilder()->helpers(['Siezi/SimpleCaptcha.SimpleCaptcha']);
        if ($this->request->session()->check('Auth.User')) {
            return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        }
        if ($this->request->is('post')) {
			
			\JCryption::decrypt();
			$this->request->data  = $_REQUEST;
			
            $captchaValidator = new \Siezi\SimpleCaptcha\Model\Validation\SimpleCaptchaValidator();
            $errors = $captchaValidator->errors($this->request->data);

            if ((isset($errors['captcha']['_empty'])) && (!empty($errors['captcha']['_empty']))) {
                $errors['captcha']['_empty'] = 'Please enter below calculation value.';
            } else if ((isset($errors['captcha']['captcha'])) && (!empty($errors['captcha']['captcha']))) {
                $errors['captcha']['_empty'] = 'Wrong calculation entered in calculation box.';
            } else if (isset($errors['captcha_time'])) {
                $errors['captcha']['_empty'] = 'Please enter captcha, once again.';
            }
            if (empty($errors)) {

                $user = $this->Auth->identify();
                /*if($user['role_id'] != 1){
                    $this->Flash->error(__('Access Denied'));
                }else{*/
				if ($user) {
					$this->Auth->setUser($user);
					return $this->redirect($this->Auth->redirectUrl());
				}else{
					$this->Flash->error(__('Invalid username or password, try again'));
				}
                //}
            } else {
                $this->Flash->error(__($errors['captcha']['_empty']));
            }
        }
    }

    /**
     * Logout method
     *
     */
    public function logout() {
        $this->Flash->success(__('You has been logged out successfully!'));
        return $this->redirect($this->Auth->logout());
    }

    /**
     * ForgotPassword method
     *
     */
    public function forgotPassword() {
        if ($this->request->session()->check('Auth.User')) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        if ($this->request->is('post')) {
            if (!empty($this->request->data('email'))) {
                $email = $this->request->data('email');
                $User = $this->Users->findAllByEmail($email)->first();

                //print_r($User);exit;
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
                        
						try {
							$this->Email->send($emailData);
						} catch (Exception $e) {
							echo 'Exception : ',  $e->getMessage(), "\n";
						}
						
                        $this->Flash->success(__('Password reset instructions have been sent to your email address. You have 24 hours to complete the request.'));
                        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                    } else {
                        $this->Flash->error(__('Email not send successfully, try again'));
                        return $this->redirect(['controller' => 'Users', 'action' => 'forgotPassword']);
                    }
                } else {
                    $this->Flash->error(__('Invalid username, try again'));
                    return $this->redirect(['controller' => 'Users', 'action' => 'forgotPassword']);
                }
            } else {
                $this->Flash->error(__('Please enter username'));
            }
        }
    }

    /**
     * ResetPassword method
     *
     * @param $fp_token
     */
    public function resetPassword($fp_token = null) {

        $this->viewBuilder()->helpers(['Siezi/SimpleCaptcha.SimpleCaptcha']);
        if ($this->request->session()->check('Auth.User')) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        
        $user = $this->Users->newEntity();
        if (isset($fp_token)) {
            $fpToken = $this->Users->findByFpToken($fp_token)->first();

            if ($fpToken) {
                $tokenGeneratedDate = $fpToken['fp_token_at'];
                $convertDate = date("Y-m-d", strtotime($tokenGeneratedDate));
                if (strtotime($convertDate) <= strtotime('-1 day')) {
                    $fpToken->fp_token = NULL;
                    $fpToken->fp_token_at = NULL;
                    $this->Users->save($fpToken);
                    $this->Flash->error('Your link has been expired, try again.');
                    return $this->redirect(['controller' => 'Users', 'action' => 'forgotPassword']);
                } else {
                    if ($this->request->is('post')) {
                        
                        $captchaValidator = new \Siezi\SimpleCaptcha\Model\Validation\SimpleCaptchaValidator();
                        $errors = $captchaValidator->errors($this->request->data);

                        if ((isset($errors['captcha']['_empty'])) && (!empty($errors['captcha']['_empty']))) {
                            $errors['captcha']['_empty'] = 'Please enter below calculation value.';
                        } else if ((isset($errors['captcha']['captcha'])) && (!empty($errors['captcha']['captcha']))) {
                            $errors['captcha']['_empty'] = 'Wrong calculation entered in calculation box.';
                        } else if (isset($errors['captcha_time'])) {
                            $errors['captcha']['_empty'] = 'Please enter captcha, once again.';
                        }
                        if (empty($errors)) {
                            $user = $this->Users->patchEntity($fpToken, [
                                'password' => $this->request->data['password'],
                                'confirm_password' => $this->request->data['confirm_password']
                                    ], ['validate' => 'resetPassword']);
                            $user->fp_token = NULL;
                            $user->fp_token_at = NULL;
                            if ($this->Users->save($user)) {
                                //Email
                                /* $emailData = [
                                  'helpers' => ['Html'],
                                  'template' => 'resetpassword',
                                  'emailFormat' => 'html',
                                  'to' => trim($user->email),
                                  'subject' =>__('Your password has been reset successfully'),
                                  'viewVars' => [ 'user' => $user ]
                                  ];
                                  $this->Email->send($emailData); */
                                $this->Flash->success(__('Your password has been reset successfully'));
                                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                            }
                        } else {
                            $this->Flash->error(__($errors['captcha']['_empty']));
                        }
                    }
                }
            } else {
                $this->Flash->error(__('Invalid Token.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        } else {
            $this->Flash->error(__('Something missing in URL.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        $this->set(compact('fp_token', 'user'));
        $this->set('_serialize', ['fp_token']);
    }

    /**
     * ChangePassword method
     *
     */
    public function changePassword() {
        $user = $this->Users->newEntity();
        if ($this->request->is(['post', 'put'])) {
			\JCryption::decrypt();
			$this->request->data  = $_REQUEST;
            $user = $this->Users->get($this->Auth->user('id'));
            $user = $this->Users->patchEntity($user, [
                'current_password' => $this->request->data['current_password'],
                'password' => $this->request->data['password'],
                'confirm_password' => $this->request->data['confirm_password']
                    ], ['validate' => 'changePassword']);
            if ($this->Users->save($user)) {
                //Email
                /* $emailData = [
                  'helpers' => ['Html'],
                  'template' => 'changepassword',
                  'emailFormat' => 'html',
                  'to' => trim($user->email),
                  'subject' =>__('Your password has been changed successfully'),
                  'viewVars' => [ 'user' => $user ]
                  ];
                  $this->Email->send($emailData); */
                $this->Flash->success(__('Your password has been changed successfully'));
                return $this->redirect(['controller' => 'Users', 'action' => 'myProfile']);
            } else {
                $this->Flash->error(__('The password could not be changed. Please, try again.'));
            }
        }
        $this->set(compact('user'));
    }

    /**
     * MyProfile method
     *
     */
    public function myProfile() {
        $user_id = $this->Auth->user('id');
        $this->view($user_id);
        $this->render('view');
    }

}
