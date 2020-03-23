<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\Utility\Text;

/**
 * FaqMaster Controller
 *
 * @property \App\Model\Table\FaqMasterTable $FaqMaster
 */
class FaqMasterController extends AppController {
    /* public $paginate = array(
      'limit' =>3 ,
      ); */

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $language = '';
        if (!empty($this->request->query['lang'])) {
            $language = $this->request->query['lang'];
            I18n::locale($this->request->query['lang']);
            $this->paginate = [
                'contain' => ['innerTranslation'],
                'conditions' => [
                    'innerTranslation.locale' => $language,
                ],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    'FaqMaster.id' => 'asc'
                ),
                'group' => 'FaqMaster.id',
            ];
        } else {
            $this->paginate = [
                'contain' => ['innerTranslation'],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    'FaqMaster.id' => 'asc'
                ),
                'group' => 'FaqMaster.id',
            ];
        }

		 
        if (!empty($this->request->query['search'])) {
             if($this->request->query['lang']=='hi'){
				$this->paginate['conditions']['AND'] = ['innerTranslation.field LIKE "faq_title"'];
				$this->paginate['conditions']['OR'] = ['innerTranslation.content LIKE' => '%'. trim($this->request->query['search']) . '%'];
              } else{
				$this->paginate['conditions']['OR'] = ['FaqMaster.faq_title LIKE' => '%' . trim($this->request->query['search']) . '%'];
			}
        }
        $faqMaster = $this->paginate($this->FaqMaster);
        $this->set(compact('faqMaster', 'language'));
        $this->set('_serialize', ['faqMaster', 'language']);
    }

    /**
     * View method
     *
     * @param string|null $id Faq Master id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $faqMaster = $this->FaqMaster->get($id, ['translations' => true]);
        //pr($faqMaster);
        $this->set('faqMaster', $faqMaster);
        $this->set('_serialize', ['faqMaster']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $faqMaster = $this->FaqMaster->newEntity();
        if ($this->request->is('post')) {
            if (!empty($this->request->data['lang'])) {
                I18n::locale($this->request->data['lang']);
            }
            $langs = ['hi'];
            $tfields = ['faq_title', 'faq_description'];
            foreach ($langs as $lang) {
                foreach ($tfields as $tfield) {
                    if (isset($this->request->data[$tfield])) {
                        $this->request->data['_translations'][$lang][$tfield] = $this->request->data[$tfield];
                    }
                }
            }
            $faqMaster = $this->FaqMaster->patchEntity($faqMaster, $this->request->data, [
                'translations' => true
                    ]);
            $faqMaster->created_at = date('Y-m-d H:i:s');
            $faqMaster->updated_at = date('Y-m-d H:i:s');
            if ($this->FaqMaster->save($faqMaster)) {
                $this->Flash->success(__('The faq master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faq master could not be saved. Please, try again.'));
        }
        $this->set(compact('faqMaster'));
        $this->set('_serialize', ['faqMaster']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Faq Master id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        if (!empty($this->request->query['lang'])) {
            I18n::locale($this->request->query['lang']);
        }
        $faqMaster = $this->FaqMaster->get(base64_decode($id), [
            'contain' => []
                ]);
        if (!empty($this->request->query['lang'])) {
            $faqMaster->lang = $this->request->query['lang'];
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (!empty($this->request->data['lang'])) {
                I18n::locale($this->request->data['lang']);
            }
            $faqMaster = $this->FaqMaster->patchEntity($faqMaster, $this->request->data, [
                'translations' => true]);
            $faqMaster->created_at = date('Y-m-d H:i:s');
            $faqMaster->updated_at = date('Y-m-d H:i:s');
            $faqMaster = $this->FaqMaster->patchEntity($faqMaster, $this->request->data);
            if ($this->FaqMaster->save($faqMaster)) {
                $this->Flash->success(__('The faq master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faq master could not be saved. Please, try again.'));
        }
        $this->set(compact('faqMaster'));
        $this->set('_serialize', ['faqMaster']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Faq Master id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $faqMaster = $this->FaqMaster->get($id);
        if ($this->FaqMaster->delete($faqMaster)) {
            $this->Flash->success(__('The faq master has been deleted.'));
        } else {
            $this->Flash->error(__('The faq master could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
