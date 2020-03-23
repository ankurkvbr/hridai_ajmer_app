<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;

/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 */
class CitiesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getCity', 'getCityByState']);
    }

    public function getcitybystate() {
        $citydata = '';
        $_resultflag = false;
        $message = "Fail";
        if ($this->request->is('post')) {
            $state_id = $this->request->data('state_id');
            if (!empty($state_id)) {
                $_resultflag = true;
                $message = "Success";
//                $citydata = $this->Cities->find('list')->where(['state_id' => $state_id])->toArray();
                $citydata = $this->Cities->find('all',array('order'=>array('name'=>'asc')))->where(['state_id' => $state_id])->toArray();
            }
        }
        $this->set(compact('_resultflag', 'message', 'citydata'));
        $this->set('_serialize', ['_resultflag', 'message', 'citydata']);
    }

}
