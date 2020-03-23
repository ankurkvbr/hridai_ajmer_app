<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Response;
use Cake\Core\Configure;
use App\Network\Session;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\I18n\Time;
use Cake\Utility\Security;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

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

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Email');
        $this->loadComponent('Auth', [
            'flash' => [
                'element' => 'error'
            ],
            'authenticate' => [

                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'home',
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'authError' => 'You are not authorized to access that location.',
            'flash' => [
                'element' => 'error'
            ]
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
		$this->loadComponent('Sanitize');
		$this->loadComponent('Cookie'); 
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf', ['httpOnly' => true]);
        $this->loadComponent('Csrf');
        //Admin LTE Theme config
        Configure::write('Theme', [
            'title' => 'Ajmer Heritage Cityguide',
            'logo' => [
                'mini' => '<b>A</b>',
                'large' => '<b>Ajmer Heritage Cityguide</b>'
            ],
            'login' => [
                'show_remember' => false,
                'show_register' => false,
                'show_social' => false
            ],
            'folder' => ROOT
        ]);
    }

    /**
     * Before filter callback.
     *
     * @param \Cake\Event\Event $event The beforeFilter event.
     * @return void
     */
    public function beforeFilter(Event $event) {
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event) {
        $this->viewBuilder()->theme('AdminLTE');
        $this->set('theme', Configure::read('Theme'));
        if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * Before redirect callback.
     *
     * @param \Cake\Event\Event $event,$url,\Cake\Network\Response $response The beforeRedirect event.
     * @return void
     */
    public function beforeRedirect(Event $event, $url, Response $response) {
		
		$_token_value = hash('sha512', Security::randomBytes(16), false);
        $expiry = new Time(0);
        $this->response->cookie([
            'name' => 'csrfToken',
            'value' => $_token_value,
            'expire' => $expiry->format('U'),
            'path' => $this->request->webroot,
            'secure' => false,
        ]);	
    }

    /**
     * after filter callback.
     *
     * @param \Cake\Event\Event $event The afterFilter event.
     * @return void
     */
    public function afterFilter(Event $event) {
        
    }

}
