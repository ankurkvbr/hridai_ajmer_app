<?php

namespace App\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;
use Cake\I18n\I18n;

/**
 * CmsPage Controller
 *
 * @property \App\Model\Table\CmsPageTable $CmsPage
 */
class CmsPageController extends AppController {
    /* public $paginate = array(
      'limit' =>2,
      ); */

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
                    'CmsPage.id' => 'asc'
                ),
            'group' => 'CmsPage.id',
        ];
        }else{
		$this->paginate = [
                'contain' => ['innerTranslation'],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    'CmsPage.id' => 'asc'
                ),
                'group' => 'CmsPage.id',
            ];
        }
		if (!empty($this->request->query['search'])) {
             if($this->request->query['lang']=='hi'){
			 $this->paginate['conditions']['AND'] = ['innerTranslation.field LIKE "name"'];
              $this->paginate['conditions']['OR'] = ['innerTranslation.content LIKE' => '%'.trim($this->request->query['search']).'%'];
              } else{
            $this->paginate['conditions']['OR'] = ['CmsPage.name LIKE' => '%' . trim($this->request->query['search']) . '%'];
			}
		}
        $cmsPage = $this->paginate($this->CmsPage);
        $this->set(compact('cmsPage', 'language'));
        $this->set('_serialize', ['cmsPage', 'language']);
    }
	/*    if (!empty($this->request->query['search'])) {
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
    }*/

    /**
     * View method
     *
     * @param string|null $id Cms Page id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $cmsPage = $this->CmsPage->get($id, ['translations' => true]
        );
        $this->set('cmsPage', $cmsPage);
        $this->set('_serialize', ['cmsPage']);
    }

    public function add() {
        $cmsPage = $this->CmsPage->newEntity($this->request->data);
        if ($this->request->is('post')) {
            if (!empty($this->request->data['lang'])) {
                I18n::locale($this->request->data['lang']);
            }
            $langs = ['hi'];
            $tfields = ['name', 'description', 'meta_title', 'meta_keywords', 'meta_description'];
            foreach ($langs as $lang) {
                foreach ($tfields as $tfield) {
                    if (isset($this->request->data[$tfield])) {
                        $this->request->data['_translations'][$lang][$tfield] = $this->request->data[$tfield];
                    }
                }
            }
            $cmsPage = $this->CmsPage->patchEntity($cmsPage, $this->request->data, [
                'translations' => true
                    ]);
            $cmsPage->created_by = $this->Auth->user('id');
            $cmsPage->created_at = date('Y-m-d H:i:s');
            $cmsPage->updated_at = date('Y-m-d H:i:s');

            $Status = $cmsPage['is_active'];
            $created_at = $cmsPage['created_at'];
            $updated_at = $cmsPage['updated_at'];
            $created_by = $cmsPage['created_by'];
            $name = $cmsPage['name'];
            $description = $cmsPage['description'];
            $meta_title = $cmsPage['meta_title'];
            $meta_keywords = $cmsPage['meta_keywords'];
            $meta_description = $cmsPage['meta_description'];
            $page = array('is_active' => $Status, 'name' => $name, 'description' => $description, 'meta_title' => $meta_title, 'meta_keywords' => $meta_keywords, 'meta_description' => $meta_description, 'created_by' => $created_by, 'created_at' => $created_at, 'updated_at' => $updated_at);
            $cmsPages = $this->CmsPage->patchEntity($cmsPage, $page);
            //echo '<pre>';print_r($cmsPages);exit;
            if ($this->CmsPage->save($cmsPages)) {
                $this->Flash->success(__('The cms page has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cms page could not be saved. Please, try again.'));
        }
        $this->set(compact('cmsPage'));
        $this->set('_serialize', ['cmsPage']);
    }

    public function edit($id = null) {
        if (!empty($this->request->query['lang'])) {
            I18n::locale($this->request->query['lang']);
        }
        $cmsPage = $this->CmsPage->get(base64_decode($id), [
            'contain' => []
                ]);
        if (!empty($this->request->query['lang'])) {
            $cmsPage->lang = $this->request->query['lang'];
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (!empty($this->request->data['lang'])) {
                I18n::locale($this->request->data['lang']);
            }
            $cmsPage = $this->CmsPage->patchEntity($cmsPage, $this->request->data, [
                'translations' => true]);
            $cmsPage->created_by = $this->Auth->user('id');
            $cmsPage->created_at = date('Y-m-d H:i:s');
            $cmsPage->updated_at = date('Y-m-d H:i:s');
            $cmsPage = $this->CmsPage->patchEntity($cmsPage, $this->request->data);
            if ($this->CmsPage->save($cmsPage)) {
                $this->Flash->success(__('The cms page has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cms page could not be saved. Please, try again.'));
        }
        $this->set(compact('cmsPage'));
        $this->set('_serialize', ['cmsPage']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cms Page id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $cmsPage = $this->CmsPage->get($id);
        if ($this->CmsPage->delete($cmsPage)) {
            $this->Flash->success(__('The cms page has been deleted.'));
        } else {
            $this->Flash->error(__('The cms page could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
