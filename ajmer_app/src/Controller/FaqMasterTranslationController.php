<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * FaqMasterTranslation Controller
 *
 * @property \App\Model\Table\FaqMasterTranslationTable $FaqMasterTranslation
 */
class FaqMasterTranslationController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->paginate = [
            'contain' => ['FaqMaster']
        ];
        $faqMasterTranslation = $this->paginate($this->FaqMasterTranslation);

        $this->set(compact('faqMasterTranslation'));
        $this->set('_serialize', ['faqMasterTranslation']);
    }

    /**
     * View method
     *
     * @param string|null $id Faq Master Translation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $faqMasterTranslation = $this->FaqMasterTranslation->get($id, [
            'contain' => ['FaqMaster']
                ]);

        $this->set('faqMasterTranslation', $faqMasterTranslation);
        $this->set('_serialize', ['faqMasterTranslation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $faqMasterTranslation = $this->FaqMasterTranslation->newEntity($this->request->data);
        if ($this->request->is('post')) {
            $faqMasterTranslation->created_at = date('Y-m-d H:i:s');
            $faqMasterTranslation->updated_at = date('Y-m-d H:i:s');
            $created_at = $faqMasterTranslation['created_at'];
            $updated_at = $faqMasterTranslation['updated_at'];
            $status = $faqMasterTranslation['is_active'];
            $title = $faqMasterTranslation['faq_title'];
            $description = $faqMasterTranslation['faq_description'];
            $lang = $faqMasterTranslation['lang'];

            $master = array('is_active' => 1, 'created_at' => $created_at, 'updated_at' => $updated_at);
            $FaqMaster = $this->FaqMasterTranslation->FaqMaster->newEntity();
            $masters = $this->FaqMasterTranslation->FaqMaster->patchEntity($FaqMaster, $master);
            $faqmasters = $this->FaqMasterTranslation->FaqMaster->save($masters);

            // $this->set('users', $this->User->find('all'));
            /*
              for($i=0;$i<0;$i++){
              $langArray = array('id'=>$id,'name'=>$name,'culture'=>$culture,'is_active'=>$is_active,'is_default'=>$is_default,'created_at'=>$created_at,'updated_at'=>$updated_at);
              echo $langArray;exit;
              //  $langArray = array();
              $langs = $this->lang->find('all');
              foreach ($langs as $lang) {
              $langArray[$lang['lang']['id']] = $lang['lang']['name'];
              }
              $this->set('departments', $departmentsArray);
              }
             */

            $master1 = array('faq_master_id' => $faqmasters->id, 'faq_title' => $title, 'faq_description' => $description, 'lang' => $lang, 'created_at' => $created_at, 'updated_at' => $updated_at);
            $FaqMaster1 = $this->FaqMasterTranslation->newEntity();
            $masters1 = $this->FaqMasterTranslation->patchEntity($FaqMaster1, $master1);
            $faqmasters1 = $this->FaqMasterTranslation->save($masters1);



            if ($faqmasters1) {
                $this->Flash->success(__('The Faq Master translation has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
        } else {
            $this->Flash->error(__('The faq master translation could not be saved. Please, try again.'));
        }
        $faqMaster = $this->FaqMasterTranslation->FaqMaster->find('list', ['limit' => 200]);
        $this->set(compact('faqMasterTranslation', 'faqMaster'));
        $this->set('_serialize', ['faqMasterTranslation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Faq Master Translation id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $faqMasterTranslation = $this->FaqMasterTranslation->get($id, [
            'contain' => []
                ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $faqMasterTranslation = $this->FaqMasterTranslation->patchEntity($faqMasterTranslation, $this->request->data);
            if ($this->FaqMasterTranslation->save($faqMasterTranslation)) {
                $this->Flash->success(__('The faq master translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faq master translation could not be saved. Please, try again.'));
        }
        $faqMaster = $this->FaqMasterTranslation->FaqMaster->find('list', ['limit' => 200]);
        $this->set(compact('faqMasterTranslation', 'faqMaster'));
        $this->set('_serialize', ['faqMasterTranslation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Faq Master Translation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $faqMasterTranslation = $this->FaqMasterTranslation->get($id);
        if ($this->FaqMasterTranslation->delete($faqMasterTranslation)) {
            $this->Flash->success(__('The faq master translation has been deleted.'));
        } else {
            $this->Flash->error(__('The faq master translation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
