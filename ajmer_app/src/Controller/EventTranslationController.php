<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * EventTranslation Controller
 *
 * @property \App\Model\Table\EventTranslationTable $EventTranslation
 */
class EventTranslationController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $eventTranslation = $this->paginate($this->EventTranslation);

        $this->set(compact('eventTranslation'));
        $this->set('_serialize', ['eventTranslation']);
    }

    /**
     * View method
     *
     * @param string|null $id Event Translation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $eventTranslation = $this->EventTranslation->get($id, [
            'contain' => []
                ]);

        $this->set('eventTranslation', $eventTranslation);
        $this->set('_serialize', ['eventTranslation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $eventTranslation = $this->EventTranslation->newEntity();
        if ($this->request->is('post')) {
            $eventTranslation = $this->EventTranslation->patchEntity($eventTranslation, $this->request->data);
            if ($this->EventTranslation->save($eventTranslation)) {
                $this->Flash->success(__('The event translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event translation could not be saved. Please, try again.'));
        }
        $this->set(compact('eventTranslation'));
        $this->set('_serialize', ['eventTranslation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Event Translation id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $eventTranslation = $this->EventTranslation->get($id, [
            'contain' => []
                ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $eventTranslation = $this->EventTranslation->patchEntity($eventTranslation, $this->request->data);
            if ($this->EventTranslation->save($eventTranslation)) {
                $this->Flash->success(__('The event translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event translation could not be saved. Please, try again.'));
        }
        $this->set(compact('eventTranslation'));
        $this->set('_serialize', ['eventTranslation']);
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
        $eventTranslation = $this->EventTranslation->get($id);
        if ($this->EventTranslation->delete($eventTranslation)) {
            $this->Flash->success(__('The event translation has been deleted.'));
        } else {
            $this->Flash->error(__('The event translation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
