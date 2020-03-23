<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * EventTranslation Controller
 *
 * @property \App\Model\Table\EventTranslationTable $EventTranslation
 */
class CraftFoodTranslationController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $craftFoodTranslation = $this->paginate($this->CraftFoodTranslation);

        $this->set(compact('craftFoodTranslation'));
        $this->set('_serialize', ['craftFoodTranslation']);
    }

    /**
     * View method
     *
     * @param string|null $id Event Translation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $craftFoodTranslation = $this->CraftFoodTranslation->get($id, [
            'contain' => []
                ]);

        $this->set('craftFoodTranslation', $craftFoodTranslation);
        $this->set('_serialize', ['craftFoodTranslation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $craftFoodTranslation = $this->CraftFoodTranslation->newEntity();
        if ($this->request->is('post')) {
            $craftFoodTranslation = $this->CraftFoodTranslation->patchEntity($craftFoodTranslation, $this->request->data);
            if ($this->CraftFoodTranslation->save($craftFoodTranslation)) {
                $this->Flash->success(__('The event translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event translation could not be saved. Please, try again.'));
        }
        $this->set(compact('craftFoodTranslation'));
        $this->set('_serialize', ['craftFoodTranslation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Event Translation id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $craftFoodTranslation = $this->CraftFoodTranslation->get($id, [
            'contain' => []
                ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $craftFoodTranslation = $this->CraftFoodTranslation->patchEntity($craftFoodTranslation, $this->request->data);
            if ($this->EventTranslation->save($craftFoodTranslation)) {
                $this->Flash->success(__('The event translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event translation could not be saved. Please, try again.'));
        }
        $this->set(compact('craftFoodTranslation'));
        $this->set('_serialize', ['craftFoodTranslation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event Translation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $craftFoodTranslation = $this->CraftFoodTranslation->get($id);
        if ($this->CraftFoodTranslation->delete($craftFoodTranslation)) {
            $this->Flash->success(__('The event translation has been deleted.'));
        } else {
            $this->Flash->error(__('The event translation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
