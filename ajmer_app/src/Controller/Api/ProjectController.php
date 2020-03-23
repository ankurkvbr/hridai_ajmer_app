<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\I18n\I18n;
use Cake\Network\Exception\NotFoundException;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * Event Controller
 *
 * @property \App\Model\Table\EventTable $Event
 */
class ProjectController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null */
    public function initialize() {

        parent::initialize();
        $this->Auth->allow(['getprojectlist']);
    }

    public function getprojectlist() {
        $this->request->allowMethod(['post']);

        $_resultflag = false;
        $message = __('Record Not Found!');
        $limit = Configure::read('page.limit');
        $path = $this->request->webroot . Configure::read('webroot.img') . "project/";

        $this->request->query += $this->request->data;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
        $image_path = "http://" . $_SERVER['SERVER_NAME'] . $path;

        $projects = $this->Project->find('all')
                ->select(['Project.id', 'Project.project_name', 'Project.address', 'Project.project_description', 'Project.state_id', 'Project.created_at',
                    'Project.cities_id', 'Project.url','Project.latitude','Project.longitude', 'city_name' => 'Cities.name', 'state_name' => 'States.name'])
                //->contain(['ProjectImages' => ['fields' => ['ProjectImages.id', 'ProjectImages.image', 'ProjectImages.project_id']]])
                ->contain(['ProjectImages' => function($q){
					$q->select([
						'ProjectImages.id',
                                            'ProjectImages.image',
                                            'ProjectImages.project_id',
                                            //'ProjectImages.shorting_order'
					]);
                                        $q->order(['ProjectImages.shorting_order' =>'ASC']);
					return $q;
				}])
                ->contain(['Cities'])
                ->contain(['States'])
                ->where(['Project.is_active' => 1])
                ->order(['Project.id'=>'DESC'])
                //->order(['ProjectImages.shorting_order' =>'ASC'])
                ->hydrate(false);

        $asProjects = $projects->toArray();
        $total_records = count($asProjects);
        if (empty($total_records)) {
            $_resultflag = true;
            $message = __('Record Not Found');
        }

        try {
            $projects = $this->paginate($projects, array('limit' => $limit));
        } catch (NotFoundException $e) {
            $projects = [];
        }
        if (!empty($projects) && $projects->count() > 0) {
            $_resultflag = true;
            $message = __('Success');
        }
        $this->set(compact('_resultflag', 'image_path', 'message', 'total_records', 'projects'));
        $this->set('_serialize', ['_resultflag', 'image_path', 'message', 'total_records', 'projects']);
    }

}
