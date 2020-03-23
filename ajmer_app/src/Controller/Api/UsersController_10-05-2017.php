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
        $this->Auth->allow(['login', 'register', 'forgotPassword']);
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

    public function register() {

        $this->request->allowMethod(['post']);
        $error = [];
        $this->request->data['dob'] = (isset($this->request->data['dob'])) ? date('Y-m-d', strtotime($this->request->data['dob'])) : '0000-00-00';
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->registration_date = date('Y-m-d H:i:s');
            $user->role_id = 2;
            //$user->confirm_password = $this->request->data['password'];
            /* $otp = $this->getPassword(5, '', 'd');
              $user->otp = $otp; */
            
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
            }else{
                if ($this->Users->save($user)) {
                    $_resultflag = true;
                    $message = __('User registered successfully.');
                    $this->set([
                        '_resultflag' => true,
                        'message' => $message,
                        'token' => JWT::encode(['sub' => $user['id'], 'exp' => time() + 604800], Security::salt()),
                        'user' => $user,
                        '_serialize' => ['_resultflag', 'message', 'token', 'user', 'error']
                    ]);
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
        $this->set(compact('_resultflag', 'message', 'user'));
//        $this->set('_serialize', ['_resultflag', 'message', 'user', 'error']);
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
                //$this->Flash->success(__('Your password has been changed successfully'));
                //return $this->redirect(['controller' => 'Users', 'action' => 'myProfile']);
            } else {
                $_resultflag = false;
                $message = __('The password could not be changed. Please, try again.');
                //$this->Flash->error(__('The password could not be changed. Please, try again.'));
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
        //$error = [];
        if($this->request->data('social_flag') != 0){
            
            $social_flag = $this->request->data['social_flag'];
            $social_id = $this->request->data['social_id'];
            
            $userchk = $this->Users->find('all')->where(['social_id = ' => $social_id , 'social_flag =' => $social_flag]);
            $asuser = $userchk->toArray();
                if(!empty($asuser)){
                $userbyid = $this->Users->get($asuser[0]->id);
                $this->Auth->setUser($userbyid);
                $this->set([
                    '_resultflag' => true,                    
                    'message' => __("Login Successfully."),
                    'token' => JWT::encode(['sub' => $userbyid['id'], 'exp' => time() + 604800], Security::salt()),
                    'user' => $userbyid,
                    '_serialize' => ['_resultflag', 'message', 'token', 'user']
                ]);

            }else{
                $this->set([
                    '_resultflag' => true,
                    'isToRegister' => true,
                    'message' => __("User not registered from social network"),
                    '_serialize' => ['_resultflag', 'isToRegister']
                ]);                            }
        }else{
        
            $user = $this->Auth->identify();
        if (!$user) {
            $this->set([
                '_resultflag' => false,
                'message' => __("Invalid Username and Password"),
                'user' => [],
                '_serialize' => ['_resultflag', 'message']
            ]);
            //throw new UnauthorizedException('Invalid username or password');
        } else {
            $this->set([
                '_resultflag' => true,
                'message' => __("Login Successfully."),
                'token' => JWT::encode(['sub' => $user['id'], 'exp' => time() + 604800], Security::salt()),
                'user' => $user,
                '_serialize' => ['_resultflag', 'message', 'token', 'user']
            ]);
            }        
        }   
        $this->set(compact('_resultflag', 'message', 'user'));

    }
    /*

      $this->set(compact('_resultflag','message','user','error'));
      $this->set('_serialize', ['_resultflag','message','user','error']);
     */
    /**
      public function login() {
      $this->request->allowMethod(['post']);
      //$error = [];
      $user = $this->Auth->identify();
      if (!$user) {
      $this->set([
      '_resultflag' => false,
      'message' => __("Invalid"),
      'user' => [],
      '_serialize' => ['_resultflag', 'message', 'user']
      ]);
      //throw new UnauthorizedException('Invalid username or password');
      } else {
      $this->set([
      '_resultflag' => true,
      'message' => __("Successfully."),
      'token' => JWT::encode(['sub' => $user['id'], 'exp' => time() + 604800], Security::salt()),
      'user' => $user,
      '_serialize' => ['_resultflag', 'message', 'token', 'user']
      ]);
      }
      $this->set(compact('_resultflag', 'message', 'user'));
      }

      /*

      $this->set(compact('_resultflag','message','user','error'));
      $this->set('_serialize', ['_resultflag','message','user','error']);
     */

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

}
