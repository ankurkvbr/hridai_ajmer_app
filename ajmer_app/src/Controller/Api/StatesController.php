<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;

/**
 * States Controller
 *
 * @property \App\Model\Table\StatesTable $States
 */
class StatesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getallstate',]);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function getAllState() {
        $_resultflag = TRUE;
        $states = $this->States->find('all',array('order'=>array('States.name'=>'asc')));
        $message = "Success";

        $this->set(compact('_resultflag', 'message', 'states'));
        $this->set('_serialize', ['_resultflag', 'message', 'states']);
    }

}
