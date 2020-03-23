<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * EventImages Controller
 *
 * @property \App\Model\Table\EventImagesTable $EventImages
 */
class EventImagesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Event']
        ];
        $eventImages = $this->paginate($this->EventImages);

        $this->set(compact('eventImages'));
        $this->set('_serialize', ['eventImages']);
    }

    /**
     * View method
     *
     * @param string|null $id Event Image id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $eventImage = $this->EventImages->get($id, [
            'contain' => ['Event']
                ]);

        $this->set('eventImage', $eventImage);
        $this->set('_serialize', ['eventImage']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $eventImage = $this->EventImages->newEntity();
        if ($this->request->is('post')) {
            $eventImage = $this->EventImages->patchEntity($eventImage, $this->request->data);
            if ($this->EventImages->save($eventImage)) {
                $this->Flash->success(__('The event image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event image could not be saved. Please, try again.'));
        }
        $event = $this->EventImages->Event->find('list', ['limit' => 200]);
        $this->set(compact('eventImage', 'event'));
        $this->set('_serialize', ['eventImage']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Event Image id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $eventImage = $this->EventImages->get($id, [
            'contain' => []
                ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $eventImage = $this->EventImages->patchEntity($eventImage, $this->request->data);
            if ($this->EventImages->save($eventImage)) {
                $this->Flash->success(__('The event image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event image could not be saved. Please, try again.'));
        }
        $event = $this->EventImages->Event->find('list', ['limit' => 200]);
        $this->set(compact('eventImage', 'event'));
        $this->set('_serialize', ['eventImage']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event Image id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $eventImage = $this->EventImages->get($id);
        if ($this->EventImages->delete($eventImage)) {
            $this->Flash->success(__('The event image has been deleted.'));
        } else {
            $this->Flash->error(__('The event image could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
