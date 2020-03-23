<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\I18n\I18n;

/**
 * CmsPage Controller
 *
 * @property \App\Model\Table\CmsPageTable $CmsPage
 */
class CmsPageController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getcmspage']);
    }

    public function getcmspage() {
        $this->request->allowMethod(['post']);
        $_resultflag = false;
        $message = __('Record Not Found!');
        $id = $this->request->data['id'];
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
        $cmsPage = $this->CmsPage->find()
                ->select(['id', 'name', 'description'])
                ->where(['CmsPage.id' => $id, 'CmsPage.is_active' => 1])
                ->first();
        $total_records = count($cmsPage);

        if (empty($total_records)) {
            $_resultflag = true;
            $message = __('Record Not Found');
        }

        if ($total_records) {
            $_resultflag = true;
            $message = __('Success');
        }
        $this->set(compact('_resultflag', 'message', 'cmsPage', 'total_records'));
        $this->set('_serialize', ['_resultflag', 'message', 'cmsPage', 'total_records']);
    }

}
