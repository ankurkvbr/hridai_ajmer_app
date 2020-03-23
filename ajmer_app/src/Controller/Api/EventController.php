<?php

namespace App\Controller\Api;

use Cake\Core\Configure;
use App\Controller\Api\AppController;
use Cake\I18n\I18n;
use Cake\Network\Exception\NotFoundException;

/**
 * Event Controller
 *
 * @property \App\Model\Table\EventTable $Event
 */
class EventController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['eventlist']);
    }

    /**
     * REST API for Event List
     * @return event detail
     */
    public function eventlist() {
        $this->request->allowMethod(['post']);
        $_resultflag = false;
        $message = __('Record Not Found!');
        $limit = Configure::read('page.limit');

        //event_flag => 1 //previousEvent =>2 //upcommingEvent
        $path = $this->request->webroot . Configure::read('webroot.img') . "event/";

        $this->request->query += $this->request->data;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
        $image_path = "http://" . $_SERVER['SERVER_NAME'] . $path;
        
        $event_flag = ($this->request->data['event_flag']) ? $this->request->data['event_flag'] : '';
        $Events = $this->Event->find('all')
                ->select(['Event.id', 'Event.event_name', 'Event.event_description', 'Event.address','Event.latitude','Event.longitude',
                    'Event.even_date_time', 'Event.state_id', 'Event.city_id', 'city_name' => 'Cities.name', 'state_name' => 'States.name'])
				//	'Event.state_id', 'Event.city_id', 'city_name' => 'Cities.name', 'state_name' => 'States.name'
               // ->contain(['EventImages' => ['fields' => ['EventImages.id', 'EventImages.image', 'EventImages.event_id']]])
                ->contain(['EventImages' => function($q){
					$q->select([
						'EventImages.id',
                                            'EventImages.image',
                                            'EventImages.event_id',
                                            //'ProjectImages.shorting_order'
					]);
                                        $q->order(['EventImages.shorting_order' =>'ASC']);
					return $q;
				}])
                ->contain(['Cities'])
                ->contain(['States'])
                ->where(['Event.is_active' => 1]);
                
                if($event_flag == 1){
                        $Events->order(['Event.even_date_time'=>'DESC']);
                        $Events->andwhere(['Event.even_date_time <=' => date('Y-m-d H:i')]);
                }
                if($event_flag == 2){
                        $Events->order(['Event.even_date_time'=>'ASC']);
                        $Events->andwhere(['Event.even_date_time >' => date('Y-m-d H:i')]);
                }
        
                $Events->hydrate(false);

        $asEvents = $Events->toArray();
        $total_records = count($asEvents);
        if (empty($total_records)) {
            $_resultflag = true;
            $message = __('Record Not Found');
        }


        try {
            $EventData = $this->paginate($Events, array('limit' => $limit));
        } catch (NotFoundException $e) {
            $EventData = [];
        }
        if (!empty($EventData) && $EventData->count() > 0) {
            $_resultflag = true;
            $message = __('Success');
        }
        $this->set(compact('_resultflag', 'message', 'total_records', 'image_path', 'Events'));
        $this->set('_serialize', ['_resultflag', 'message', 'total_records', 'image_path', 'Events']);
    }

}
