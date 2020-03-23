<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Network\Exception\NotFoundException;
//use App\View\Helper;

/**
 * Project Controller
 *
 * @property \App\Model\Table\ProjectTable $Project
 */
class ProjectController extends AppController {

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
    public function index() {
        $language = '';
        if (!empty($this->request->query['lang'])) {
            $language = $this->request->query['lang'];
            I18n::locale($this->request->query['lang']);
            $this->paginate = [
                'contain' => ['ProjectImages', 'innerTranslation'],
                'conditions' => [
                    'innerTranslation.locale' => $language,
                ],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    'Project.id' => 'desc'
                ),
                'group' => 'innerTranslation.foreign_key'
            ];
        } else {
            $this->paginate = [
                'contain' => ['ProjectImages', 'innerTranslation'],
                'limit' => Configure::read('page.limit'),
                'order' => array(
                    'Project.id' => 'desc'
                ),
                'group' => 'innerTranslation.foreign_key'
            ];
        }

        if (!empty($this->request->query['search'])) {

            if ($this->request->query['lang'] == 'hi') {
                $this->paginate['conditions']['AND'] = ['innerTranslation.field LIKE "project_name"'];
                $this->paginate['conditions']['OR'] = ['innerTranslation.content LIKE' => '%' . trim($this->request->query['search']) . '%'];
            } else {
                $this->paginate['conditions']['OR'] = ['Project.project_name LIKE' => '%' . trim($this->request->query['search']) . '%'];
            }
        }
        $project = $this->paginate($this->Project);
        $this->set(compact('project', 'language'));
        $this->set('_serialize', ['project', 'language']);
    }

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $project = $this->Project->get($id, [
            'contain' => ['States', 'Cities', 'Project_project_name_translation', 'Project_project_description_translation', 'project_translation', 'ProjectImages', 'ProjectTranslation']
        ]);

        $this->set('project', $project);
        $this->set('_serialize', ['project']);
    }

	
	public function imageshow($id) {
		$project = $this->Project->get($id);
		$this->loadModel('ProjectImages');
		
		$image=$this->paginate = [
		'limit' => Configure::read('page.limit'),
			'conditions' => [
				'project_id' => $id,
				
			]
		];
//	echo '<pre>';print_r($image);exit;
		$projectimage = $this->paginate($this->ProjectImages);
		$this->set(compact('project','projectimage'));
		$this->set('_serialize', ['project','projectimage']);
        }
        
    public function viewimages($id) {
		$project = $this->Project->get($id);
		
        $title = $project->project_name;
		//print_r($title);exit;
        $this->loadModel('ProjectImages');
        $project = $this->ProjectImages->find('all', [
            'conditions' => [
                'project_id' => "$id",
            ],
            'order' => array(
                'shorting_order' => 'asc'
            ),
        ]);
		$this->set('project', $project);
        $this->set(compact('project', 'title'), $project);
        $this->set('_serialize', ['project']);

    }
/*
    public function imageshow($id) {
        $project = $this->Project->get($id);
        $this->loadModel('ProjectImages');

        $image = $this->paginate = [
            'limit' => Configure::read('page.limit'),
            'conditions' => [
                'project_id' => $id,
            ]
        ];
        //echo '<pre>';print_r($image);exit;
        $projectimage = $this->paginate($this->ProjectImages);
        $this->set(compact('project', 'projectimage'));
        $this->set('_serialize', ['project', 'projectimage']);
    }
*/
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $project = $this->Project->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectImages = [];
            if (isset($this->request->data['project_images'])) {
                $projectImages = $this->request->data['project_images'];
                unset($this->request->data['project_images']);
            }
            $i = 0;
            foreach ($projectImages as $imgKey => $imgData) {
                if (!empty($imgData['image']['name'])) {
                    $_FILES['upload_project_image'] = $imgData['image'];
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'project')) {
                        $folder = new Folder(WWW_ROOT . 'img/project', true, 0755);
                    }
                    $imgUpload['upload_path'] = WWW_ROOT . 'img/project';
                    $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                    $imgUpload['max_size'] = 0;
                    $this->Fileupload->init($imgUpload);
                    if (!$this->Fileupload->upload('upload_project_image')) {
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
                $this->request->data['project_images'][$i] = $imgData;
                $this->request->data['project_images'][$i]['image'] = $image;
                $i++;
            }

            // Find lat & long 
           /*  if (!empty($this->request->data['address'])) {
                $address = $this->request->data['address'];
                $address = str_replace(" ", "+", $address);
                $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address");
                $json = json_decode($json);
                $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                $this->request->data['latitude'] = $lat;
                $this->request->data['longitude'] = $long;
            } */

			
            $proj_last = $this->Project->find('all')->last();
            $next_pro = $proj_last->id + 1;

            //Project Translation
            for ($i = 0; $i < 3; $i++) {
                if ($i == 0) {
                    $field = 'title';
                    $content = $this->request->data['project_name'];
                } else if ($i == 1) {
                    $field = 'description';
                    $content = $this->request->data['project_description'];
                } else if ($i == 2) {
                    $field = 'address';
                    $content = $this->request->data['address'];
                }
                $this->request->data['project_translation'][$i]['locale'] = 'hi';
                $this->request->data['project_translation'][$i]['model'] = 'Project';
                $this->request->data['project_translation'][$i]['foreign_key'] = $next_pro;
                $this->request->data['project_translation'][$i]['field'] = $field;
                $this->request->data['project_translation'][$i]['content'] = $content;
            }

            $project = $this->Project->patchEntity($project, $this->request->data);
          //  $project->cities_id = $this->request->data['city_id'];
            $project->created_at = date('Y-m-d H:i:s');
			$project->state_id = '8';
            $project->cities_id = '86';
            if ($this->Project->save($project)) {
                $this->Flash->success(__('The project has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                if (!empty($this->request->data['project_images'])) {
                    foreach ($this->request->data['project_images'] as $eImage) {
                        if (!empty($eImage['image']) && !is_array($eImage['image'])) {
                            @unlink(WWW_ROOT . 'img/project/' . $eImage['image']);
                        }
                    }
                }
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        //$states = $this->Project->States->find('list', ['limit' => 200])->order(['States.name'=>'ASC']);
        //$cities = [];
        $this->set(compact('project'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
		$language = $this->request->query['lang'];
        if (!empty($this->request->query['lang'])) {
            I18n::locale($this->request->query['lang']);
        }
        $project = $this->Project->get($id, [
            'contain' => ['ProjectImages']
        ]);
        if (!empty($this->request->query['lang'])) {
            $project->lang = $this->request->query['lang'];
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (!empty($this->request->data['lang'])) {
                I18n::locale($this->request->data['lang']);
            }
            $projectImages = (isset($this->request->data['project_images'])) ? $this->request->data['project_images'] : '';
            if ($projectImages) {
                unset($this->request->data['project_images']);
                $i = 0;

                foreach ($projectImages as $imgKey => $imgData) {
                    if (!empty($imgData['image']['name'])) {

                        $_FILES['upload_project_image'] = $imgData['image'];
                        if (!is_dir(WWW_ROOT . 'img' . DS . 'project')) {
                            $folder = new Folder(WWW_ROOT . 'img/project', true, 0755);
                        }
                        $imgUpload['upload_path'] = WWW_ROOT . 'img/project';
                        $imgUpload['allowed_types'] = 'jpg|jpeg|png|gif';
                        $imgUpload['max_size'] = 0;
                        $this->Fileupload->init($imgUpload);
                        if (!$this->Fileupload->upload('upload_project_image')) {
                            $fError = $this->Fileupload->errors();
                            if ($fError[0] == 'upload_invalid_filetype') {
                                $image = ['_error' => 'ExtNotAllowed'];
                            } else {
                                $image = ['_error' => 'FileNotUpload'];
                            }
                        } else {
                            $image = $this->Fileupload->output('file_name');
                        }
                        $this->request->data['project_images'][$i] = $imgData;
                        $this->request->data['project_images'][$i]['image'] = $image;
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
            }
            // find lat long 
            /* if (!empty($this->request->data['address'])) {
                $address = $this->request->data['address'];
                $address = str_replace(" ", "+", $address);

                $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address");
                $json = json_decode($json);

                $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                $this->request->data['latitude'] = $lat;
                $this->request->data['longitude'] = $long;
            } */
			

            $project = $this->Project->patchEntity($project, $this->request->data);
            $project->updated_at = date('Y-m-d H:i:s');
			$project->state_id = '8';
            $project->cities_id = '86';
            if ($this->Project->save($project)) {
                $this->Flash->success(__('The project has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            echo "<pre>";
            print_r($project->errors());
            exit;
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        $states = $this->Project->States->find('list', ['limit' => 200])->order(['States.name'=>'ASC']);
        if (isset($project->state_id)) {
            $cities = $this->Project->Cities->find('list', ['limit' => 200])->where(['state_id' => $project->state_id]);
        } else {
            $cities = []; //$this->Event->Cities->find('list', ['limit' => 200]);
        }
        $this->set(compact('project', 'states', 'cities','language'));
        $this->set('_serialize', ['project','language']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Project->get($id);
        if ($this->Project->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteimage() {
        $this->request->allowMethod(['post']);
        $projectImgId = $this->request->data('img_id');
        $this->loadModel('ProjectImages');
        $entity = $this->ProjectImages->get($projectImgId);
        if ($this->ProjectImages->delete($entity)) {
            if (file_exists(WWW_ROOT . 'img/project/' . $entity->image)) {
                @unlink(WWW_ROOT . 'img/project/' . $entity->image);
            }
            print_r(json_encode(array("status" => "success", "msg" => "Project image has been deleted")));
            exit;
        } else {
            print_r(json_encode(array("status" => "fail", "msg" => "Project image could not be deleted. Please, try again.")));
            exit;
        }
        return $this->redirect(['action' => 'index']);
    }

    public function changeorder() {
        $this->request->allowMethod(['post']);
        $projectImgId = $this->request->data('item');
        $order = 1;
        $error = FALSE;
        $this->loadModel('ProjectImages');
        foreach ($projectImgId as $item) {
            $projectImg = $this->ProjectImages->get($item);
            $projectImg->shorting_order = $order;
            if (!$this->ProjectImages->save($projectImg)) {
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
