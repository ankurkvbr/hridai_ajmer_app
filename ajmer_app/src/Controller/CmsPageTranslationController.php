<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * CmsPageTranslation Controller
 *
 * @property \App\Model\Table\CmsPageTranslationTable $CmsPageTranslation
 */
class CmsPageTranslationController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->paginate = [
            'contain' => ['CmsPage']
        ];
        $cmsPageTranslation = $this->paginate($this->CmsPageTranslation);

        $this->set(compact('cmsPageTranslation'));
        $this->set('_serialize', ['cmsPageTranslation']);
    }

    /**
     * View method
     *
     * @param string|null $id Cms Page Translation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $cmsPageTranslation = $this->CmsPageTranslation->get($id, [
            'contain' => ['CmsPage', 'LanguageMaster']
                ]);

        $this->set('cmsPageTranslation', $cmsPageTranslation);
        $this->set('_serialize', ['cmsPageTranslation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        //$this->loadModel('LanguageMaster');
        //$states = $this->LanguageMaster->find('list', ['limit' => 200]);
        $users_table = TableRegistry::get('LanguageMaster');

        $user_collection = $users_table->find()->all()->toArray();
        //echo '<pre>';print_r($user_collection); exit;



        $cmsPageTranslation = $this->CmsPageTranslation->newEntity($this->request->data);

        if ($this->request->is('post')) {
            /* $cmsPageTranslation->created_by = '1';
              $cmsPageTranslation->created_at = date('Y-m-d H:i:s');
              $cmsPageTranslation->updated_at = date('Y-m-d H:i:s');

              $Status = $cmsPageTranslation['is_active'];
              $created_at=$cmsPageTranslation['created_at'];
              $updated_at=$cmsPageTranslation['updated_at'];
              $name=$cmsPageTranslation['name'];
              $description=$cmsPageTranslation['description'];
              $meta_title=$cmsPageTranslation['meta_title'];
              $meta_keywords=$cmsPageTranslation['meta_keywords'];
              $meta_description=$cmsPageTranslation['meta_description'];
              $lang=$cmsPageTranslation['lang'];
              $created_by=$cmsPageTranslation['created_by'];
              $page=array('is_active'=>$Status,'created_at'=>$created_at,'updated_at'=>$updated_at);

              $CmsPage = $this->CmsPageTranslation->CmsPage->newEntity();

              $CmsPages = $this->CmsPageTranslation->CmsPage->patchEntity($CmsPage,$page);

              $Cms=$this->CmsPageTranslation->CmsPage->save($CmsPages);

              $id=$Cms['id'];
              $page1=array('cms_page_id'=>$id,'name'=>$name,'description'=>$description,'meta_title'=>$meta_title,'meta_keywords'=>$meta_keywords,'meta_description'=>$meta_description,'lang'=>$lang,'created_by'=>$created_by,'created_at'=>$created_at,'updated_at'=>$updated_at);
              $cmsPageTranslation = $this->CmsPageTranslation->patchEntity($cmsPageTranslation,$page1); */

            if ($this->CmsPageTranslation->save($cmsPageTranslation)) {


                $this->Flash->success(__('The cms page translation has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cms page translation could not be saved. Please, try again.'));
            }
        }

        $cmsPage = $this->CmsPageTranslation->CmsPage->find('list', ['limit' => 200]);
        $this->set(compact('cmsPageTranslation', 'cmsPage'));
        $this->set('_serialize', ['cmsPageTranslation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cms Page Translation id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $cmsPageTranslation = $this->CmsPageTranslation->get($id, [
            'contain' => []
                ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cmsPageTranslation = $this->CmsPageTranslation->patchEntity($cmsPageTranslation, $this->request->data);
            if ($this->CmsPageTranslation->save($cmsPageTranslation)) {
                $this->Flash->success(__('The cms page translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cms page translation could not be saved. Please, try again.'));
        }
        $cmsPage = $this->CmsPageTranslation->CmsPage->find('list', ['limit' => 200]);
        $this->set(compact('cmsPageTranslation', 'cmsPage'));
        $this->set('_serialize', ['cmsPageTranslation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cms Page Translation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $cmsPageTranslation = $this->CmsPageTranslation->get($id);
        if ($this->CmsPageTranslation->delete($cmsPageTranslation)) {
            $this->Flash->success(__('The cms page translation has been deleted.'));
        } else {
            $this->Flash->error(__('The cms page translation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
