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
class CraftFoodController extends AppController {

    public $components = ['Fileupload'];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		if (in_array($this->request->action, ['deleteimage', 'edit', 'changeorder','addsort'])) {
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
                'contain' => ['CraftFoodImages', 'innerTranslation'],
                'conditions' => [
                    'innerTranslation.locale' => $language,
                ],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    //'CraftFood.id' => 'desc'
                    'CraftFood.sort_order' => 'asc'
                ),
                'group' => 'CraftFood.id',
            ];
        } else {
            $this->paginate = [
                'contain' => ['CraftFoodImages'],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    //'CraftFood.id' => 'desc'
					'CraftFood.sort_order' => 'asc'
                ),
				//'group' => 'innerTranslation.foreign_key'
            ];
        }

        if (!empty($this->request->query['search'])) {
            if ($this->request->query['lang'] == 'hi') {
                $this->paginate['conditions']['AND'] = ['innerTranslation.field LIKE "title"'];
                $this->paginate['conditions']['OR'] = ['innerTranslation.content LIKE' => '%' . trim($this->request->query['search']) . '%'];
            } else {
                $this->paginate['conditions']['OR'] = ['CraftFood.title LIKE' => '%' . trim($this->request->query['search']) . '%'];
            }
        }
        if (!empty($this->request->query['craftfood_category'])) {
            $this->paginate['conditions']['AND'] = ['CraftFood.Category LIKE' => trim($this->request->query['craftfood_category'])];
        }
        $craftfoods = $this->paginate($this->CraftFood);
        $this->set(compact('craftfoods', 'language'));
        $this->set('_serialize', ['craftfoods', 'language']);
    }

    /**
     * View method
     *
     * @param string|null $id Monuments Garden id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $craftfood = $this->CraftFood->find('all');

        $this->set('craftfood', $craftfoods);
        $this->set('_serialize', ['craftfood']);
    }

    /* public function viewreview($id) {
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
      } */

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
		
		/*for($i=0; $i<=100; $i++){
			$sort_order[] = $i;	
		}*/
        $craftfood = $this->CraftFood->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {

            $craftfoodsImg = [];
            if (isset($this->request->data['craftfoods_images'])) {
                $craftfoodsImg = $this->request->data['craftfoods_images'];
                unset($this->request->data['craftfoods_images']);
            }
	
            $i = 0;
            foreach ($craftfoodsImg as $imgKey => $imgData) {
                if (!empty($imgData['image']['name'])) {
                    $_FILES['upload_craftfoods_images'] = $imgData['image'];
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'craftfood')) {
                        $folder = new Folder(WWW_ROOT . 'img/craftfood', true, 0755);
                    }
                    $imgUpload['upload_path'] = WWW_ROOT . 'img/craftfood';
                    $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                    $imgUpload['max_size'] = 0;
                    $this->Fileupload->init($imgUpload);
                    if (!$this->Fileupload->upload('upload_craftfoods_images')) {
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
                $this->request->data['craft_food_images'][$i] = $imgData;
                $this->request->data['craft_food_images'][$i]['image'] = $image;

                $this->request->data['craft_food_images'][$i]['is_default'] = 1;
                $this->request->data['craft_food_images'][$i]['is_active'] = 1;
                $this->request->data['craft_food_images'][$i]['created_at'] = date('Y-m-d H:i:s');
                $this->request->data['craft_food_images'][$i]['updated_at'] = date('Y-m-d H:i:s');
                $i++;
            }

            $craftfoodsg = $this->CraftFood->find('all')->last();
			//echo "<pre>";print_r($craftfoodsg);exit();
            $next_monu = $craftfoodsg->id + 1;
            //craft foods Translation
            for ($i = 0; $i < 5; $i++) {
                if ($i == 0) {
                    $field = 'title';
                    $content = $this->request->data['title'];
                } else if ($i == 1) {
                    $field = 'description';
                    $content = $this->request->data['description'];
                } else if ($i == 2) {
                    $field = 'short_description';
                    $content = $this->request->data['short_description'];
                } else if ($i == 3) {
                    $field = 'address';
                    $content = $this->request->data['address'];
                } 
				/*else if ($i == 4) {
                    $field = 'sort_order';
                    $content = $this->request->data['sort_order'];
                }*/
                $this->request->data['craft_food_translation'][$i]['locale'] = 'hi';
                $this->request->data['craft_food_translation'][$i]['model'] = 'CraftFood';
                $this->request->data['craft_food_translation'][$i]['foreign_key'] = $next_monu;
                $this->request->data['craft_food_translation'][$i]['field'] = $field;
                $this->request->data['craft_food_translation'][$i]['content'] = $content;
            }

            $craftfood = $this->CraftFood->patchEntity($craftfood, $this->request->data);

            $craftfood->category = $this->request->data['craftfood_category'];    //1 means craft
            // Find lat & long
			/*
            if (!empty($this->request->data['address'])) {
                //start get lat long from address
                $address = $this->request->data['address'];
                $address = str_replace(" ", "+", $address);
                $region = '';
                $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
                $json = json_decode($json);
                if (!empty($json->results)) {
                    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                }
                //end get lat long from address
            }
			$craftfood->latitude = isset($lat) ? $lat : 0;
            $craftfood->longitude = isset($long) ? $long : 0;
			*/
            $craftfood->created_at = date('Y-m-d H:i:s');
            $craftfood->updated_at = date('Y-m-d H:i:s');
			//$craftfood->sort_order = $this->request->data['sort_order'];
            
            if ($this->CraftFood->save($craftfood)) {
                $this->Flash->success(__('The craft food has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                if (!empty($this->request->data['craftfoods_images'])) {
                    foreach ($this->request->data['craftfoods_images'] as $eImage) {
                        if (!empty($eImage['image']) && !is_array($eImage['image'])) {
                            @unlink(WWW_ROOT . 'img/craftfood/' . $eImage['image']);
                        }
                    }
                }
                $this->Flash->error(__('The Craft Food could not be saved. Please, try again.'));
            }
            /* echo "<pre>";print_r($craftfood->errors());exit; */
            $this->Flash->error(__('The Craft Food could not be saved. Please, try again.'));
        }

        $this->set(compact('craftfood'));
        $this->set('_serialize', ['craftfood']);
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
        $craftfood = $this->CraftFood->get($id, [
            'contain' => ['CraftFoodImages']
        ]);
        if (!empty($this->request->query['lang'])) {
            $craftfood->lang = $this->request->query['lang'];
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            if (!empty($this->request->data['lang'])) {
                I18n::locale($this->request->data['lang']);
            }

            //////////////////////////////////////////////////////////////////

            if (isset($this->request->data['craftfoods_images'])) {
                $craftfoodImages = $this->request->data['craftfoods_images'];
                unset($this->request->data['craftfoods_images']);
            }

            $i = 0;
            foreach ($craftfoodImages as $imgKey => $imgData) {
                if (!empty($imgData['image']['name'])) {
                    $_FILES['upload_craftfoods_image'] = $imgData['image'];
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'craftfood')) {
                        $folder = new Folder(WWW_ROOT . 'img/craftfood', true, 0755);
                    }
                    $imgUpload['upload_path'] = WWW_ROOT . 'img/craftfood';
                    $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                    $imgUpload['max_size'] = 0;
                    $this->Fileupload->init($imgUpload);
                    if (!$this->Fileupload->upload('upload_craftfoods_image')) {
                        $fError = $this->Fileupload->errors();
                        if ($fError[0] == 'upload_invalid_filetype') {
                            $image = ['_error' => 'ExtNotAllowed'];
                        } else {
                            $image = ['_error' => 'FileNotUpload'];
                        }
                    } else {
                        $image = $this->Fileupload->output('file_name');
                    }
                    $this->request->data['craft_food_images'][$i] = $imgData;
                    $this->request->data['craft_food_images'][$i]['image'] = $image;

                    $this->request->data['craft_food_images'][$i]['is_default'] = 1;
                    $this->request->data['craft_food_images'][$i]['is_active'] = 1;
                    $this->request->data['craft_food_images'][$i]['created_at'] = date('Y-m-d H:i:s');
                    $this->request->data['craft_food_images'][$i]['updated_at'] = date('Y-m-d H:i:s');
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
            $craftfood = $this->CraftFood->patchEntity($craftfood, $this->request->data);
            $craftfood->updated_at = date('Y-m-d H:i:s');
			//$craftfood->sort_order = $this->request->data['sort_order'];

            // Find lat & long
			/*
            if (!empty($this->request->data['address'])) {
                //start get lat long from address
                $address = $this->request->data['address'];
                $address = str_replace(" ", "+", $address);
                $region = '';
                $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
                $json = json_decode($json);
                if (!empty($json->results)) {
                    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                }
                //end get lat long from address
            }
            $craftfood->latitude = isset($lat) ? $lat : 0;
            $craftfood->longitude = isset($long) ? $long : 0;
			*/
            if ($this->CraftFood->save($craftfood)) {
                $this->Flash->success(__('The Craft Food has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            // echo "<pre>";print_r($craftfood->errors());exit;
            $this->Flash->error(__('The Craft Food could not be saved. Please, try again.'));
        }

        $this->set(compact('craftfood', 'language'));
        $this->set('_serialize', ['craftfood', 'language']);
    }
	
	/**
     * addsort method
     *
     * @param string|null $id Monuments Garden id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function addsort() {
        
		$craftid = $_POST['craftid'];
		$sort_order = $_POST['sort_val'];
        $this->CraftFood->updateAll(array('sort_order' => $sort_order),array('id' => $craftid));
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
        $craftfood = $this->CraftFood->get($id);
        if ($this->CraftFood->delete($craftfood)) {
            $this->Flash->success(__('The craft food has been deleted.'));
        } else {
            $this->Flash->error(__('The craft food could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteimage() {

        $this->request->allowMethod(['post']);
        $ImgId = $this->request->data('img_id');
        $this->loadModel('CraftFoodImages');
        $entity = $this->CraftFoodImages->get($ImgId);
        if ($this->CraftFoodImages->delete($entity)) {
            if (file_exists(WWW_ROOT . 'img/craftfood/' . $entity->image)) {
                @unlink(WWW_ROOT . 'img/craftfood/' . $entity->image);
            }
            print_r(json_encode(array("status" => "success", "msg" => "Craft food image has been deleted")));
            exit;
        } else {
            print_r(json_encode(array("status" => "fail", "msg" => "Craft food image could not be deleted. Please, try again.")));
            exit;
        }

        return $this->redirect(['action' => 'index']);
    }

    public function viewimages($id) {

        $craftfood = $this->CraftFood->get($id);
        $title = $craftfood->title;

        $this->loadModel('CraftFoodImages');
        $project = $this->CraftFoodImages->find('all', [
            'conditions' => [
                'craft_food_id' => "$id",
            ],
            'order' => array(
                'shorting_order' => 'asc'
            ),
        ]);
        $this->set('craft_food', $project);
        //$this->set('_serialize', ['craft_food','title']);

        $this->set(compact('craft_food', 'title'), $project);
        $this->set('_serialize', ['craft_food', 'title']);
    }

    public function changeorder() {
        $this->request->allowMethod(['post']);
        $projectImgId = $this->request->data('item');
        $order = 1;
        $error = FALSE;
        $this->loadModel('CraftFoodImages');
        foreach ($projectImgId as $item) {
            $projectImg = $this->CraftFoodImages->get($item);
            $projectImg->shorting_order = $order;
            if (!$this->CraftFoodImages->save($projectImg)) {
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
