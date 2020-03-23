<?php

namespace App\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;
use Cake\Utility\Text;

/**
 * Event Controller
 *
 * @property \App\Model\Table\EventTable $Event
 */
class FeedbackController extends AppController {

    public function initialize() {
        parent::initialize();
        //$this->Auth->allow(['getfeedbacklist','addfeedback']);
    }
    
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Users'],
            'limit' => Configure::read('page.limit'),
        ];
        if (!empty($this->request->query['search'])) {
            $this->paginate['conditions']['OR'] = ['Feedback.description LIKE' => '%' . trim($this->request->query['search']) . '%'];
        }
		//        if (!empty($this->request->query['search_email'])) {
		//            $this->paginate['conditions'][]['AND'] = ['Users.email LIKE' => '%' . trim($this->request->query['search_email']) . '%'];
		//        }
		//        if (!empty($this->request->query['search_mobile'])) {
		//            $this->paginate['conditions'][]['AND'] = ['Users.mobile_no LIKE' => trim($this->request->query['search_mobile'])];
		//        }

        $feedback = $this->paginate($this->Feedback);
		//echo '<pre>';print_r($feedback);exit;
        $this->set(compact('feedback'));
        $this->set('_serialize', ['feedback']);
    }
	
	/**
     * Delete method
     *
     * @param string|null $id Monuments Garden id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $feedbacks = $this->Feedback->get($id);
        if ($this->Feedback->delete($feedbacks)) {
            $this->Flash->success(__('The feedback has been deleted.'));
        } else {
            $this->Flash->error(__('The feedback could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
}
