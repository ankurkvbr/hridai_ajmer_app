<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

/**
 * Event Controller
 *
 * @property \App\Model\Table\EventTable $Event
 */
class EventController extends AppController {

    public $components = ['Fileupload'];
	
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		if (in_array($this->request->action, ['deleteimage', 'edit', 'changeorder'])) {
            $this->eventManager()->off($this->Csrf);
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    /* public $paginate = array(
      'limit' => 10 ,
      ); */
    public function index() {
        //$data = $this->Event->find('all')->contain(['innerTranslation'])->toArray();
        $language = '';
        if (!empty($this->request->query['lang'])) {
            $language = $this->request->query['lang'];
            I18n::locale($this->request->query['lang']);
            $this->paginate = [
                'contain' => ['EventImages', 'innerTranslation'],
                'conditions' => [
                    'innerTranslation.locale' => $language,
                ],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    'Event.id' => 'desc'
                ),
                'group' => 'Event.id',
            ];
        } else {
            $this->paginate = [
                'contain' => ['EventImages', 'innerTranslation'],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    'Event.id' => 'desc'
                ),
                'group' => 'innerTranslation.foreign_key'
            ];
        }

        if (!empty($this->request->query['search'])) {
            if ($this->request->query['lang'] == 'hi') {
                $this->paginate['conditions']['AND'] = ['innerTranslation.field LIKE "event_name"'];
                $this->paginate['conditions']['OR'] = ['innerTranslation.content LIKE' => '%' . trim($this->request->query['search']) . '%'];
            } else {
                $this->paginate['conditions']['OR'] = ['Event.event_name LIKE' => '%' . trim($this->request->query['search']) . '%'];
            }
        }

        $event = $this->paginate($this->Event);
        $this->set(compact('event', 'language'));
        $this->set('_serialize', ['event', 'language']);
    }

    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $event = $this->Event->get($id, [
            'contain' => ['States', 'Cities', 'Event_event_name_translation', 'Event_event_description_translation', 'event_translation', 'EventImages']
                ]);

        $this->set('event', $event);
        $this->set('_serialize', ['event']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $event = $this->Event->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            //debug($this->request->data['even_date_time']);exit();
            $eventImages = [];
            if (isset($this->request->data['event_images'])) {
                $eventImages = $this->request->data['event_images'];
                unset($this->request->data['event_images']);
            }
            $i = 0;
            foreach ($eventImages as $imgKey => $imgData) {
                if (!empty($imgData['image']['name'])) {
                    $_FILES['upload_event_image'] = $imgData['image'];
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'event')) {
                        $folder = new Folder(WWW_ROOT . 'img/event', true, 0755);
                    }
                    $imgUpload['upload_path'] = WWW_ROOT . 'img/event';
                    $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                    $imgUpload['max_size'] = 0;
                    $this->Fileupload->init($imgUpload);
                    if (!$this->Fileupload->upload('upload_event_image')) {
                        $fError = $this->Fileupload->errors();
                        if ($fError[0] == 'upload_invalid_filetype') {
                            $image = ['_error' => 'ExtNotAllowed'];
                        } else {
                            $image = ['_error' => 'FileNotUpload'];
                        }
                    } else {
                        $image = $this->Fileupload->output('file_name');
                    }
                } else {
                    $image = NULL;
                }
                unset($imgData['image']);
                $this->request->data['event_images'][$i] = $imgData;
                $this->request->data['event_images'][$i]['image'] = $image;
                $i++;
            }
            // Find lat & long 
/*            if (!empty($this->request->data['address'])) {
                $address = $this->request->data['address'];
                $address = str_replace(" ", "+", $address);
                $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address");
                $json = json_decode($json);
                if(!empty($json->results)){
                    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                    $this->request->data['latitude'] = $lat;
                    $this->request->data['longitude'] = $long;
                }
            }
*/

            $even_date_time = str_replace('/', '-',$this->request->data['even_date_time']);
            $this->request->data['even_date_time'] = date('Y-m-d H:i:s', strtotime($even_date_time));
            
            

            $event_last = $this->Event->find('all')->last();
            $next_event = $event_last->id + 1;
            //Monuments Gardens Translation
            for ($i = 0; $i < 3; $i++) {
                if ($i == 0) {
                    $field = 'event_name';
                    $content = $this->request->data['event_name'];
                } else if ($i == 1) {
                    $field = 'event_description';
                    $content = trim($this->request->data['event_description']);
                } else if ($i == 2) {
                    $field = 'address';
                    $content = $this->request->data['address'];
                } 
                $this->request->data['event_translation'][$i]['locale'] = 'hi';
                $this->request->data['event_translation'][$i]['model'] = 'Event';
                $this->request->data['event_translation'][$i]['foreign_key'] = $next_event;
                $this->request->data['event_translation'][$i]['field'] = $field;
                $this->request->data['event_translation'][$i]['content'] = $content;
            }

            $event = $this->Event->patchEntity($event, $this->request->data);
			
            $event->created_at = date('Y-m-d H:i:s');
			$event->state_id = '8';
            $event->city_id = '86';
            if ($this->Event->save($event)) {
                $this->Flash->success(__('The event has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                if (!empty($this->request->data['event_images'])) {
                    foreach ($this->request->data['event_images'] as $eImage) {
                        if (!empty($eImage['image']) && !is_array($eImage['image'])) {
                            @unlink(WWW_ROOT . 'img/event/' . $eImage['image']);
                        }
                    }
                }
                $this->Flash->error(__('The event could not be saved. Please, try again.'));
            }
        }
        $states = $this->Event->States->find('list', ['limit' => 200])->order(['States.name'=>'ASC']);
        if (isset($event->state_id)) {
            $cities = $this->Event->Cities->find('list', ['limit' => 200])->where(['state_id' => $event->state_id]);
        } else {
            $cities = []; //$this->Event->Cities->find('list', ['limit' => 200]);
        }
        $this->set(compact('event', 'states', 'cities'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Event id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $language = $this->request->query['lang'];
        if (!empty($this->request->query['lang'])) {
            I18n::locale($this->request->query['lang']);
        }
        $event = $this->Event->get($id, [
            'contain' => ['EventImages']
                ]);
        
        if (!empty($this->request->query['lang'])) {
            $event->lang = $this->request->query['lang'];
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
			
			if (!empty($this->request->data['lang'])) {
                I18n::locale($this->request->data['lang']);
            }
			if (isset($this->request->data['event_images'])) {
                $eventImages = $this->request->data['event_images'];
                   unset($this->request->data['event_images']);
            }			
         
            $i = 0;
            foreach ($eventImages as $imgKey => $imgData) {
                if (!empty($imgData['image']['name'])) {
                    $_FILES['upload_event_image'] = $imgData['image'];
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'event')) {
                        $folder = new Folder(WWW_ROOT . 'img/event', true, 0755);
                    }
                    $imgUpload['upload_path'] = WWW_ROOT . 'img/event';
                    $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                    $imgUpload['max_size'] = 0;
                    $this->Fileupload->init($imgUpload);
                    if (!$this->Fileupload->upload('upload_event_image')) {
                        $fError = $this->Fileupload->errors();
                        if ($fError[0] == 'upload_invalid_filetype') {
                            $image = ['_error' => 'ExtNotAllowed'];
                        } else {
                            $image = ['_error' => 'FileNotUpload'];
                        }
                    } else {
                        $image = $this->Fileupload->output('file_name');
                    }
					$this->request->data['event_images'][$i] = $imgData;
					$this->request->data['event_images'][$i]['image'] = $image;
                } else {
                    if (!empty($imgData['uploaded'])) {
                        $image = $imgData['uploaded'];
                    } else {
                        $image = NULL;
                    }
                }
                unset($imgData['image']);
                $i++;
            }
            // find lat long 
/*            
            if (!empty($this->request->data['address'])) {
                $address = $this->request->data['address'];
                $address = str_replace(" ", "+", $address);

                $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address");
                $json = json_decode($json);

                if(!empty($json->results)){
                    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                    $this->request->data['latitude'] = $lat;
                    $this->request->data['longitude'] = $long;
                }
            }
*/
            $even_date_time = str_replace('/', '-',$this->request->data['even_date_time']);
            $this->request->data['even_date_time'] = date('Y-m-d H:i:s', strtotime($even_date_time));

            $event = $this->Event->patchEntity($event, $this->request->data);
			$event->state_id = '8';
            $event->city_id = '86';
            $event->updated_at = date('Y-m-d H:i:s');
            if ($this->Event->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));
        }
        $states = $this->Event->States->find('list', ['limit' => 200])->order(['States.name'=>'ASC']);
        if (isset($event->state_id)) {
            $cities = $this->Event->Cities->find('list', ['limit' => 200])->where(['state_id' => $event->state_id]);
        } else {
            $cities = [];
        }
        $this->set(compact('event', 'states', 'cities','language'));
        $this->set('_serialize', ['event','language']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Event->get($id);
        if ($this->Event->delete($event)) {
            $this->Flash->success(__('The event has been deleted.'));
        } else {
            $this->Flash->error(__('The event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getCityByState() {
        $this->autoRender = false;
        $citydata = [];
        if ($this->request->is('post')) {
            $state_id = $this->request->data('state_id');
            //print_r($state_id);exit;
            $this->loadModel('Cities');
            if (!empty($state_id)) {
                $citydata = $this->Cities->find('list')->where(['state_id' => $state_id]);
            }
        }
        echo json_encode(['cities' => $citydata]);
    }


    public function deleteimage() {
		
        $this->request->allowMethod(['post']);
        $ImgId = $this->request->data('img_id');
        $this->loadModel('EventImages');
        $entity = $this->EventImages->get($ImgId);
        if ($this->EventImages->delete($entity)) {
            if (file_exists(WWW_ROOT . 'img/event/' . $entity->image)) {
                @unlink(WWW_ROOT . 'img/event/' . $entity->image);
            }
            print_r(json_encode(array("status" => "success", "msg" => "Event image has been deleted")));
            exit;
        } else {
            print_r(json_encode(array("status" => "fail", "msg" => "Event image could not be deleted. Please, try again.")));
            exit;
        }
        return $this->redirect(['action' => 'index']);
    }
		
    public function viewimages($id) {
        $event = $this->Event->get($id);
		//print_r($event);exit;
        $title = $event->event_name;
	   $this->loadModel('EventImages');
        $event = $this->EventImages->find('all', [
            'conditions' => [
                'event_id' => "$id",
            ],
            'order' => array(
                'shorting_order' => 'asc'
            ),
        ]);
        $this->set('event', $event);
		 $this->set(compact('event', 'title'), $event);
        $this->set('_serialize', ['event','title']);
        
    }
    
    public function changeorder() {
        $this->request->allowMethod(['post']);
        $eventImgId = $this->request->data('item');
        $order = 1;
        $error = FALSE;
        $this->loadModel('EventImages');
        foreach ($eventImgId as $item) {
            $eventImg = $this->EventImages->get($item);
            $eventImg->shorting_order = $order;
            if (!$this->EventImages->save($eventImg)) {
                $error = TRUE;
            }
            $order++;
        }
        if ($error) {
            echo "Photo order not changed";
            exit;
        }
        echo "Saved photo order";
        exit;
    }

}
