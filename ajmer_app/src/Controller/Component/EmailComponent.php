<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * Email Component
 *
 * @author        Zankat Kalpesh
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class EmailComponent extends Component {

    public function send(array $data, $emailConfig = 'default') {

        if (!isset($data['from'])) {
            $data['from'] = 'do-not-reply@silvertouch.com';
        }
        //Email Obj
        $email = new Email($emailConfig);
        //set templatepath
        if (!empty($this->request->params['prefix'])) {
            if (isset($data['template']) && !is_array($data['template'])) {
                $data['template'] = ucfirst($this->request->params['prefix']) . '/' . $data['template'];
            }
        }
        //set property
        foreach ($data as $method => $args) {
            $email->{$method}($args);
        }
        //send
        $status = $email->send();
        return $status;
    }

}