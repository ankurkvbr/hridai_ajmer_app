<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\I18n\I18n;
use Cake\Network\Exception\NotFoundException;
use Cake\Core\Configure;

/**
 * FaqMaster Controller
 *
 * @property \App\Model\Table\FaqMasterTable $FaqMaster
 */
class FaqMasterController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getfaqmaster']);
    }

    public function getfaqmaster() {
        $this->request->allowMethod(['post']);
        $_resultflag = false;
        $message = __('Record Not Found!');
        //$limit = (Configure::read('page.limit')) ? Configure::read('page.limit') : 10;

        $this->request->query += $this->request->data;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }

        /* $Faqmaster = $this->FaqMaster->find('all')	
          ->select(['id','faq_title','faq_description'])
          //->contain(['Users'])
          ->where(['is_active'=>1]); */


        $this->paginate = [
            'fields' => ['id', 'faq_title', 'faq_description'],
            'conditions' => ['is_active' => 1],
            'order' => array(
                    'id' => 'desc'
                ),

        ];

        try {
            $faqMaster = $this->paginate($this->FaqMaster);
        } catch (NotFoundException $e) {
            $faqMaster = [];
        }
        if (!empty($faqMaster) && $faqMaster->count() > 0) {
            $_resultflag = true;
            $message = __('Success');
        }
        $this->set(compact('_resultflag', 'message', 'faqMaster'));
        $this->set('_serialize', ['_resultflag', 'message', 'faqMaster']);
    }

}
