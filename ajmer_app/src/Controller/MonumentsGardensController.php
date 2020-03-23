<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\Event\Event;
use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

//use Cake\ORM\ResultSet;

/**
 * MonumentsGardens Controller
 *
 * @property \App\Model\Table\MonumentsGardensTable $MonumentsGardens
 */
class MonumentsGardensController extends AppController {

    public $components = ['Fileupload'];
	
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		if (in_array($this->request->action, ['deleteimage', 'edit', 'changeorder', 'addsort'])) {
            $this->eventManager()->off($this->Csrf);
        }
    }
	
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
                //'fields' => ['MonumentsGardens.title','MonumentsGardens.created_at','States.name','Cities.name'],
                'contain' => ['MonumentsGardensImages', 'innerTranslation'],
                'conditions' => [
                    'innerTranslation.locale' => $language,
                ],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    //'MonumentsGardens.id' => 'desc'
                    'MonumentsGardens.sort_order' => 'asc'
                ),
                'group' => 'MonumentsGardens.id',
				
            ];
        } else {
            $this->paginate = [
                'contain' => ['MonumentsGardensImages'],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    //'MonumentsGardens.id' => 'desc'
					'MonumentsGardens.sort_order' => 'asc'
                )
            ];
        }

        if (!empty($this->request->query['search'])) {
            if ($this->request->query['lang'] == 'hi') {
                $this->paginate['conditions']['AND'] = ['innerTranslation.field LIKE "title"'];
                $this->paginate['conditions']['OR'] = ['innerTranslation.content LIKE' => '%' . trim($this->request->query['search']) . '%'];
            } else {
                $this->paginate['conditions']['OR'] = ['MonumentsGardens.title LIKE' => '%' . trim($this->request->query['search']) . '%'];
            }
        }
        if (!empty($this->request->query['monuments_category'])) {
            $this->paginate['conditions']['AND'] = ['MonumentsGardens.Category LIKE' => trim($this->request->query['monuments_category'])];
        }
        $monumentsgardens = $this->paginate($this->MonumentsGardens);
        $this->set(compact('monumentsgardens', 'language'));
        $this->set('_serialize', ['monumentsgardens', 'language']);
    }

    /**
     * View method
     *
     * @param string|null $id Monuments Garden id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $monumentsgardens = $this->MonumentsGardens->find('all');

        $this->set('monumentsgardens', $monumentsgardens);
        $this->set('_serialize', ['monumentsgardens']);
    }

    public function viewreview($id) {
        $review = $this->MonumentsGardens->get($id);
        $this->loadModel('MonumentReview');
        if ($this->request->is(['post'])) {
            $updatereview = $this->MonumentReview->get($this->request->query['id']);
            $updatereview = $this->MonumentReview->patchEntity($updatereview, $this->request->query);
            $updatereview = $this->MonumentReview->save($updatereview);
        }

        $this->paginate = [
            'limit' => Configure::read('page.limit'),
            'conditions' => [
                'monument_id' => $id,
            ]
        ];
        //$limit = Configure::read('page.limit');
        $monumentreviews = $this->paginate($this->MonumentReview);
        $this->set(compact('monumentreviews', 'review', 'publish'));
        $this->set('_serialize', ['monumentreviews', 'review', 'publish']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
		
		/*for($i=0; $i<=100; $i++){
			$sort_order[] = $i;	
		}*/
        $monumentsgardens = $this->MonumentsGardens->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $monumentsgardensAudio = $monumentsgardensAudioImage = [];
            if (isset($this->request->data['audio'])) {
                $monumentsgardensAudio = $this->request->data['audio'];
                unset($this->request->data['audio']);
            }

            if (isset($this->request->data['audio_cover_image'])) {
                $monumentsgardensAudioImage = $this->request->data['audio_cover_image'];
                unset($this->request->data['audio_cover_image']);
            }

            ////////////////////////////////////////////////
            if (!empty($monumentsgardensAudio['name'])) {
                $_FILES['audio'] = $monumentsgardensAudio;

                if (!is_dir(WWW_ROOT . 'img' . DS . 'monumentsgardens_audio')) {
                    $folder = new Folder(WWW_ROOT . 'img/monumentsgardens_audio', true, 0755);
                }

                $imgUpload['upload_path'] = WWW_ROOT . 'img/monumentsgardens_audio';
                $filename = $imgUpload['upload_path'] . '/' . $monumentsgardensAudio['name'];

                $imgUpload['allowed_types'] = array('audio/mpeg', 'audio/mpeg3', 'audio/mpg', 'audio/x-mpeg', 'audio/mp3', 'application/force-download', 'application/octet-stream');
                if (!in_array($monumentsgardensAudio['type'], $imgUpload['allowed_types'])) {
                    $audio = ['_error' => 'ExtNotAllowed'];
                }
//                        if($monumentsgardensAudio['size'] > 10000000){
//                            $audio = ['_error' => 'MaxAllowSize'];
//                        }
                /* copy uploaded file */
                if (move_uploaded_file($monumentsgardensAudio['tmp_name'], $filename)) {
                    //$this->redirect(array('action' => 'index'));
                    $audio = $monumentsgardensAudio['name'];
                } else {
                    $audio = ['_error' => 'FileNotUpload'];
                }
            } else {
                $audio = NULL;
            }
            unset($monumentsgardensAudio['name']);
            ////////////////////////////////////////////////
            ////////////////////////////////////////////////
            if (!empty($monumentsgardensAudioImage['name'])) {

                $_FILES['audio_cover_image'] = $monumentsgardensAudioImage;

                if (!is_dir(WWW_ROOT . 'img' . DS . 'monumentsgardens_audio')) {
                    $folder = new Folder(WWW_ROOT . 'img/monumentsgardens_audio_cover_image', true, 0755);
                }
                $imgUpload['upload_path'] = WWW_ROOT . 'img/monumentsgardens_audio_cover_image';
                $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                $imgUpload['max_size'] = 0;
                $this->Fileupload->init($imgUpload);
                if (!$this->Fileupload->upload('audio_cover_image')) {
                    $fError = $this->Fileupload->errors();
                    if ($fError[0] == 'upload_invalid_filetype') {
                        $audio_cover = ['_error' => 'ExtNotAllowed'];
                    } else {
                        $audio_cover = ['_error' => 'FileNotUpload'];
                    }
                } else {
                    $audio_cover = $this->Fileupload->output('file_name');
                }
            } else {
                $audio_cover = NULL;
            }
            unset($monumentsgardensAudioImage['name']);
            ////////////////////////////////////////////////

            $monumentsgardensImg = [];

            if (isset($this->request->data['monumentsgardens_images'])) {
                $monumentsgardensImg = $this->request->data['monumentsgardens_images'];
                unset($this->request->data['monumentsgardens_images']);
            }

            $this->request->data['audio'] = $_FILES['audio']['name'];
            $this->request->data['audio_cover_image'] = $_FILES['audio_cover_image']['name'];

            $i = 0;
            foreach ($monumentsgardensImg as $imgKey => $imgData) {
                if (!empty($imgData['image']['name'])) {
                    $_FILES['upload_monumentsgardens_image'] = $imgData['image'];
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'monumentsgardens')) {
                        $folder = new Folder(WWW_ROOT . 'img/monumentsgardens', true, 0755);
                    }
                    $imgUpload['upload_path'] = WWW_ROOT . 'img/monumentsgardens';
                    $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                    $imgUpload['max_size'] = 0;
                    $this->Fileupload->init($imgUpload);
                    if (!$this->Fileupload->upload('upload_monumentsgardens_image')) {
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
                $this->request->data['monuments_gardens_images'][$i] = $imgData;
                $this->request->data['monuments_gardens_images'][$i]['image'] = $image;

                $this->request->data['monuments_gardens_images'][$i]['is_default'] = 1;
                $this->request->data['monuments_gardens_images'][$i]['is_active'] = 1;
                $this->request->data['monuments_gardens_images'][$i]['created_at'] = date('Y-m-d H:i:s');
                $this->request->data['monuments_gardens_images'][$i]['updated_at'] = date('Y-m-d H:i:s');
                $i++;
            }

            $monumentsg = $this->MonumentsGardens->find('all')->last();
            $next_monu = $monumentsg->id + 1;
            //Monuments Gardens Translation
            for ($i = 0; $i < 5; $i++) {
                if ($i == 0) {
                    $field = 'title';
                    $content = $this->request->data['title'];
                } else if ($i == 1) {
                    $field = 'description';
                    $content = $this->request->data['description'];
                } else if ($i == 2) {
                    $field = 'address';
                    $content = $this->request->data['address'];
                } else if ($i == 3) {
                    $field = 'tour_title';
                    $content = $this->request->data['tour_title'];
                } 
				/*else if ($i == 4) {
                    $field = 'sort_order';
                    $content = $this->request->data['sort_order'];
                }*/
                $this->request->data['monuments_gardens_translation'][$i]['locale'] = 'hi';
                $this->request->data['monuments_gardens_translation'][$i]['model'] = 'MonumentsGardens';
                $this->request->data['monuments_gardens_translation'][$i]['foreign_key'] = $next_monu;
                $this->request->data['monuments_gardens_translation'][$i]['field'] = $field;
                $this->request->data['monuments_gardens_translation'][$i]['content'] = $content;
            }
			
            $monumentsgardens = $this->MonumentsGardens->patchEntity($monumentsgardens, $this->request->data);
			
          //  $monumentsgardens->category = $this->request->data['monuments_category'];    //1 means monuments
            // Find lat & long
			/*
             if (!empty($this->request->data['address'])) {
                //start get lat long from address
                $address = $this->request->data['address'];
                $address = str_replace(" ", "+", $address);
                $region = '';
                $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
                $json = json_decode($json);
                if(!empty($json->results)){
                    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                }
                //end get lat long from address
            } 
			$monumentsgardens->latitude = isset($lat) ? $lat : 0;
            $monumentsgardens->longitude = isset($long) ? $long : 0;
			*/
          //  $monumentsgardens->cities_id = $this->request->data['city_id'];
            $monumentsgardens->created_at = date('Y-m-d H:i:s');
            $monumentsgardens->updated_at = date('Y-m-d H:i:s');
           // $monumentsgardens->sort_order = $this->request->data['sort_order'];
			$monumentsgardens->state_id = '8';
            $monumentsgardens->cities_id = '86';

            if ($this->MonumentsGardens->save($monumentsgardens)) {
                $this->Flash->success(__('The discoveries has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                if (!empty($this->request->data['monumentsgardens_images'])) {
                    foreach ($this->request->data['monumentsgardens_images'] as $eImage) {
                        if (!empty($eImage['image']) && !is_array($eImage['image'])) {
                            @unlink(WWW_ROOT . 'img/monumentsgardens/' . $eImage['image']);
                        }
                    }
                }
                $this->Flash->error(__('The discoveries could not be saved. Please, try again.'));
            }
            /*echo "<pre>";
            print_r($monumentsgardens->errors());
            exit;*/
            $this->Flash->error(__('The discoveries could not be saved. Please, try again.'));
        }
        $states = $this->MonumentsGardens->States->find('list', ['limit' => 200])->order(['States.name'=>'ASC']);
//        if (isset($monumentsgardens->state_id)) {
//            $cities = $this->Event->Cities->find('list', ['limit' => 200])->where(['state_id' => $monumentsgardens->state_id]);
//        } else {
        $cities = []; //$this->Event->Cities->find('list', ['limit' => 200]);
//        }
        //$this->set(compact('monumentsgardens', 'states', 'cities', 'sort_order'));
		$this->set(compact('monumentsgardens', 'states', 'cities'));
        $this->set('_serialize', ['monumentsgardens']);
    }

    /**
     * Edit method
     *
     * @param string|null $id monumentsgardens id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
		
		/*for($i=0; $i<=100; $i++){
			$sort_order[] = $i;	
		}*/
		$language = $this->request->query['lang'];
        if (!empty($this->request->query['lang'])) {
            I18n::locale($this->request->query['lang']);
        }
        $monumentsgardens = $this->MonumentsGardens->get($id, [
            'contain' => ['MonumentsGardensImages']
                ]);
        if (!empty($this->request->query['lang'])) {
            $monumentsgardens->lang = $this->request->query['lang'];
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            if (!empty($this->request->data['lang'])) {
                I18n::locale($this->request->data['lang']);
            }
            //////////////////////////////////////////////////////////////////
            $monumentsgardensAudio = $monumentsgardensAudioImage = [];
            if (isset($this->request->data['audio'])) {
                $monumentsgardensAudio = $this->request->data['audio'];
                unset($this->request->data['audio']);
            }

            if (isset($this->request->data['audio_cover_image'])) {
                $monumentsgardensAudioImage = $this->request->data['audio_cover_image'];
                unset($this->request->data['audio_cover_image']);
            }
            
////////////////////////////////////////////////
            if (!empty($monumentsgardensAudio['name'])) {
                $_FILES['audio'] = $monumentsgardensAudio;

                if (!is_dir(WWW_ROOT . 'img' . DS . 'monumentsgardens_audio')) {
                    $folder = new Folder(WWW_ROOT . 'img/monumentsgardens_audio', true, 0755);
                }

                $imgUpload['upload_path'] = WWW_ROOT . 'img/monumentsgardens_audio';
                $filename = $imgUpload['upload_path'] . '/' . $monumentsgardensAudio['name'];

                $imgUpload['allowed_types'] = array('audio/mpeg', 'audio/mpeg3', 'audio/mpg', 'audio/x-mpeg', 'audio/mp3', 'application/force-download', 'application/octet-stream');
                if (!in_array($monumentsgardensAudio['type'], $imgUpload['allowed_types'])) {
                    $audio = ['_error' => 'ExtNotAllowed'];
                }
//                        if($monumentsgardensAudio['size'] > 10000000){
//                            $audio = ['_error' => 'MaxAllowSize'];
//                        }
                /* copy uploaded file */
                if (move_uploaded_file($monumentsgardensAudio['tmp_name'], $filename)) {
                    //$this->redirect(array('action' => 'index'));
                    $audio = $monumentsgardensAudio['name'];
                } else {
                    $audio = ['_error' => 'FileNotUpload'];
                }
            } else {
                $audio = NULL;
            }
            unset($monumentsgardensAudio['name']);
            ////////////////////////////////////////////////
            ////////////////////////////////////////////////
            if (!empty($monumentsgardensAudioImage['name'])) {

                $_FILES['audio_cover_image'] = $monumentsgardensAudioImage;

                if (!is_dir(WWW_ROOT . 'img' . DS . 'monumentsgardens_audio')) {
                    $folder = new Folder(WWW_ROOT . 'img/monumentsgardens_audio_cover_image', true, 0755);
                }
                $imgUpload['upload_path'] = WWW_ROOT . 'img/monumentsgardens_audio_cover_image';
                $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                $imgUpload['max_size'] = 0;
                $this->Fileupload->init($imgUpload);
                if (!$this->Fileupload->upload('audio_cover_image')) {
                    $fError = $this->Fileupload->errors();
                    if ($fError[0] == 'upload_invalid_filetype') {
                        $audio_cover = ['_error' => 'ExtNotAllowed'];
                    } else {
                        $audio_cover = ['_error' => 'FileNotUpload'];
                    }
                } else {
                    $audio_cover = $this->Fileupload->output('file_name');
                }
            } else {
                $audio_cover = NULL;
            }
            unset($monumentsgardensAudioImage['name']);
            ////////////////////////////////////////////////

            //////////////////////////////////////////////////////////////////
            
            
            
            
            
            if (isset($this->request->data['monumentsgardens_images'])) {
                $monumentsgardensImages = $this->request->data['monumentsgardens_images'];
                unset($this->request->data['monumentsgardens_images']);
            }
            
            $this->request->data['audio'] = $_FILES['audio']['name'];
            $this->request->data['audio_cover_image'] = $_FILES['audio_cover_image']['name'];

            //  $monumentsgardensImages = $this->request->data['monumentsgardens_images'];
            //  unset($this->request->data['monumentsgardens_images']);
            $i = 0;
            foreach ($monumentsgardensImages as $imgKey => $imgData) {
                if (!empty($imgData['image']['name'])) {
                    $_FILES['upload_monumentsgardens_image'] = $imgData['image'];
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'monumentsgardens')) {
                        $folder = new Folder(WWW_ROOT . 'img/monumentsgardens', true, 0755);
                    }
                    $imgUpload['upload_path'] = WWW_ROOT . 'img/monumentsgardens';
                    $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                    $imgUpload['max_size'] = 0;
                    $this->Fileupload->init($imgUpload);
                    if (!$this->Fileupload->upload('upload_monumentsgardens_image')) {
                        $fError = $this->Fileupload->errors();
                        if ($fError[0] == 'upload_invalid_filetype') {
                            $image = ['_error' => 'ExtNotAllowed'];
                        } else {
                            $image = ['_error' => 'FileNotUpload'];
                        }
                    } else {
                        $image = $this->Fileupload->output('file_name');
                    }
                    $this->request->data['monuments_gardens_images'][$i] = $imgData;
                    $this->request->data['monuments_gardens_images'][$i]['image'] = $image;

                    $this->request->data['monuments_gardens_images'][$i]['is_default'] = 1;
                    $this->request->data['monuments_gardens_images'][$i]['is_active'] = 1;
                    $this->request->data['monuments_gardens_images'][$i]['created_at'] = date('Y-m-d H:i:s');
                    $this->request->data['monuments_gardens_images'][$i]['updated_at'] = date('Y-m-d H:i:s');
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
            $monumentsgardens = $this->MonumentsGardens->patchEntity($monumentsgardens, $this->request->data);
            $monumentsgardens->updated_at = date('Y-m-d H:i:s');
			//$monumentsgardens->sort_order = $this->request->data['sort_order'];
			$monumentsgardens->state_id = '8';
            $monumentsgardens->cities_id = '86';
            // Find lat & long
			/*
             if (!empty($this->request->data['address'])) {
                //start get lat long from address
                $address = $this->request->data['address'];
                $address = str_replace(" ", "+", $address);
                $region = '';
                $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
                $json = json_decode($json);
                if(!empty($json->results)){
                    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                }
                //end get lat long from address
            } 
            $monumentsgardens->latitude = isset($lat) ? $lat : 0;
            $monumentsgardens->longitude = isset($long) ? $long : 0;
            */
            $monumentsgardens->audio =($this->request->data['audio'] != '') ? $this->request->data['audio'] : $monumentsgardens->audio;
            $monumentsgardens->audio_cover_image =($this->request->data['audio_cover_image'] != '') ? $this->request->data['audio_cover_image'] : $monumentsgardens->audio_cover_image;

            $path = $this->request->webroot.Configure::read('webroot.img');//."monumentsgardens_audio/";
            if ($this->MonumentsGardens->save($monumentsgardens)) {
//                    if($this->request->data['audio'] != ''){
//                        $audio_path = '..'.$path.'monumentsgardens_audio/'.$monumentsgardens->audio;
//                        unlink($audio_path);
//                    }
//                    if($this->request->data['audio_cover_image'] != ''){
//                        $audio_path = '..'.$path.'monumentsgardens_audio_cover_image/'.$monumentsgardens->audio_cover_image;
//                        unlink($audio_path);
//                    }         
                $this->Flash->success(__('The discoveries has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            
            //echo "<pre>";print_r($monumentsgardens->errors());exit;
            $this->Flash->error(__('The discoveries could not be saved. Please, try again.'));
        }
        $states = $this->MonumentsGardens->States->find('list', ['limit' => 200])->order(['States.name'=>'ASC']);
        if (isset($monumentsgardens->state_id)) {
            $cities = $this->MonumentsGardens->Cities->find('list', ['limit' => 200])->where(['state_id' => $monumentsgardens->state_id]);
        } else {
            $cities = []; //$this->Event->Cities->find('list', ['limit' => 200]);
        }
        //$this->set(compact('monumentsgardens', 'states', 'cities','language', 'sort_order'));
		$this->set(compact('monumentsgardens', 'states', 'cities','language'));
        $this->set('_serialize', ['monumentsgardens','language']);
    }
	
	/**
     * addsort method
     *
     * @param string|null $id Monuments Garden id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function addsort() {
        
		$monumentid = $_POST['monumentid'];
		$sort_order = $_POST['sort_val'];
        $this->MonumentsGardens->updateAll(array('sort_order' => $sort_order),array('id' => $monumentid));
        /*if ($this->CraftFood->updateAll(array('sort_order' => $sort_order),array('id' => $id))) {
            $this->Flash->success(__('The sort order has been updated.'));
        } else {
            $this->Flash->error(__('The sort order could not be updated. Please, try again.'));
        }*/
        return $this->redirect(['action' => 'index']);
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
        $monumentsgardens = $this->MonumentsGardens->get($id);
        if ($this->MonumentsGardens->delete($monumentsgardens)) {
            $this->Flash->success(__('The discoveries has been deleted.'));
        } else {
            $this->Flash->error(__('The discoveries could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteimage() {

        $this->request->allowMethod(['post']);
        $ImgId = $this->request->data('img_id');
        $this->loadModel('MonumentsGardensImages');
        $entity = $this->MonumentsGardensImages->get($ImgId);
        if ($this->MonumentsGardensImages->delete($entity)) {
            if (file_exists(WWW_ROOT . 'img/monumentsgardens/' . $entity->image)) {
                @unlink(WWW_ROOT . 'img/monumentsgardens/' . $entity->image);
            }
            print_r(json_encode(array("status" => "success", "msg" => "Discoveries image has been deleted")));
            exit;
        } else {
            print_r(json_encode(array("status" => "fail", "msg" => "Discoveries image could not be deleted. Please, try again.")));
            exit;
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function viewimages($id) {
        
        $monumentsgardens = $this->MonumentsGardens->get($id);
        $title = $monumentsgardens->title;

        $this->loadModel('MonumentsGardensImages');
        $project = $this->MonumentsGardensImages->find('all', [
            'conditions' => [
                'monument_id' => "$id",
            ],
            'order' => array(
                'shorting_order' => 'asc'
            ),
        ]);
        $this->set('monuments_gardens', $project);
        //$this->set('_serialize', ['monuments_gardens','title']);
        
        $this->set(compact('monuments_gardens', 'title'), $project);
        $this->set('_serialize', ['monuments_gardens','title']);
    }
    
    public function changeorder() {
        $this->request->allowMethod(['post']);
        $projectImgId = $this->request->data('item');
        $order = 1;
        $error = FALSE;
        $this->loadModel('MonumentsGardensImages');
        foreach ($projectImgId as $item) {
            $projectImg = $this->MonumentsGardensImages->get($item);
            $projectImg->shorting_order = $order;
            if (!$this->MonumentsGardensImages->save($projectImg)) {
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