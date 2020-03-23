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
class MyAjmerController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getmyajmerlist','addmyajmer','deletemyajmer']);
    }

    /**
     * REST API for Event List
     * @return event detail
     */
    public function getmyajmerlist() {
        $this->request->allowMethod(['post']);
        $_resultflag = false;
        $message = __('Record Not Found!');
        $limit = Configure::read('page.limit');

        $this->request->query += $this->request->data;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
        $userId = isset($this->request->data['user_id']) ? $this->request->data['user_id'] : '';
        $ajmer_type = isset($this->request->data['ajmer_type']) ? $this->request->data['ajmer_type'] : '';
        if($userId != '' && $ajmer_type != '' ){
			
			if($ajmer_type == '1'){
				$que = ['MyAjmer.id',
						'MyAjmer.user_id',
						'first_name' 		=> 'User.first_name',
						'ajmertype'  		=> "IF(MyAjmer.ajmer_type = '1', 'Event', 'Monument Garden')",
						'favourite_type_id'	=> "IF(MyAjmer.ajmer_type = '1', Event.event_name, '')",
						'Event.id',
						'Event.event_name',
						'Event.event_description',
						'Event.address',
						'Event.latitude',
						'Event.longitude',
						'Event.even_date_time',
						'Event.state_id',
						'Event.city_id',
						'event_city_name' => 'Cities.name',
						'event_state_name' => 'States.name',
						'EventImages.id',
						'EventImages.image',
						'EventImages.event_id',];
						
				
				/*$contains = [
					'EventImages' => function($q){
						$q->select([
							'EventImages.id',
												'EventImages.image',
												'EventImages.event_id',
						]);
						$q->order(['EventImages.shorting_order' =>'ASC']);
						return $q;
					}
				];*/
				
				$joins = [
					'a' => [
						'table' => 'event',
                        'alias' => 'Event',
                        'type' => 'LEFT',
                        'conditions' => array('Event.id = MyAjmer.favourite_type_ids')
					],
					'b' => [
						'table' => 'cities',
						'alias' => 'Cities',
						'type' => 'LEFT',
						'conditions' => array('Cities.id = Event.city_id')
					],
					'd' => [
                        'table' => 'states',
                        'alias' => 'States',
                        'type' => 'LEFT',
                        'conditions' => array('States.id = Event.state_id')
					],
					'e' => [
						'table' => 'event_images',
                        'alias' => 'EventImages',
                        'type' => 'LEFT',
                        'conditions' => array('EventImages.event_id = Event.id')
					]
				];

			}elseif($ajmer_type == '2'){
				$que = ['MyAjmer.id',
						'MyAjmer.user_id',
						'first_name' 		=> 'User.first_name',
						'ajmertype'  		=> "IF(MyAjmer.ajmer_type = '2', 'Event', 'Monument Garden')",
						'favourite_type_id'	=> "IF(MyAjmer.ajmer_type = '2', '', MonumentsGardens.title)",
						'MonumentsGardens.id', 
						'MonumentsGardens.title',
						'MonumentsGardens.description',
						'MonumentsGardens.state_id',
						'MonumentsGardens.cities_id', 
						'city_name' => 'Cities.name',
						'state_name' =>'States.name',
						'MonumentsGardens.latitude',
						'MonumentsGardens.address',
						'MonumentsGardens.longitude',
						'MonumentsGardens.tour_title',
						'MonumentsGardens.tour_video',
						'MonumentsGardens.latitude',
						'MonumentsGardens.longitude',
						'video_thumb' => 'MonumentsGardens.tour_video',
						'audio' => 'MonumentsGardens.audio',
						'audio_cover_image' => 'MonumentsGardens.audio_cover_image'];
				
				/*$contains = [
					'MonumentsGardensImages' =>
						['fields' => ['MonumentsGardensImages.id', 
									  'MonumentsGardensImages.image',
									  'MonumentsGardensImages.monument_id']
						],
					'MonumentReview' => function($q){
						$q->select([
							'MonumentReview.monument_id',
							'ratingAvg' => $q->func()->avg('MonumentReview.rating'),
							'totalReview' => $q->func()->count('MonumentReview.monument_id')
						]);
						$q->where(['MonumentReview.is_publish' => 1]);
						$q->group(['MonumentReview.monument_id']);
						return $q;
					}	
				];	*/	
						
				$joins = [
					'c' => [
						'table' => 'monuments_gardens',
						'alias' => 'MonumentsGardens',
						'type' => 'LEFT',
						'conditions' => array('MonumentsGardens.id = MyAjmer.favourite_type_ids')
					],
					'u' => [
						'table' => 'cities',
                        'alias' => 'Cities',
                        'type' => 'LEFT',
                        'conditions' => array('Cities.id = MonumentsGardens.cities_id')
					],
					'p' => [
						 'table' => 'states',
                         'alias' => 'States',
                         'type' => 'LEFT',
                         'conditions' => array('States.id = MonumentsGardens.state_id')
					]
				];		
			}

            $favouriteList = $this->MyAjmer->find('all')
                    ->select($que)
                    ->join($joins)
                    ->join([
                            'table' => 'users',
                            'alias' => 'User',
                            'type' => 'INNER',
                            'conditions' => array('User.id = MyAjmer.user_id')
                    ])
                    ->where(['MyAjmer.user_id' => $userId,'MyAjmer.ajmer_type' => $ajmer_type]);
                    $favouriteList->hydrate(false);

            $asList = $favouriteList->toArray();
            $total_records = count($asList);
            
            if (empty($total_records)) {
                $_resultflag = true;
                $message = __('Record Not Found');
            }
            try {
                $myAmjerData = $this->paginate($favouriteList, array('limit' => $limit));
            } catch (NotFoundException $e) {
                $myAmjerData = [];
            }
            if (!empty($myAmjerData) && $myAmjerData->count() > 0) {
                $_resultflag = true;
                $message = __('Success');
            }

        }else{
            $_resultflag = false;
            $favouriteList = '';
            $message = __('Missing required parameter');
            $this->set(compact('_resultflag', 'message'));
            $this->set('_serialize', ['_resultflag', 'message']);
        }

        $this->set(compact('_resultflag', 'message', 'total_records', 'favouriteList'));
        $this->set('_serialize', ['_resultflag', 'message', 'total_records', 'favouriteList']);
    }
	
	/**
     * REST API for Event List
     * @return get ajmer list
     */
    public function addmyajmer() {
        $this->request->allowMethod(['post']);
		
        $favouriteList = $this->MyAjmer->find('all')->where(['MyAjmer.user_id' => $this->request->data['user_id'],'MyAjmer.ajmer_type' => $this->request->data['ajmer_type'],'MyAjmer.favourite_type_ids' => $this->request->data['favourite_type_ids']]);
        if(empty($favouriteList->toArray())){
            $myajmer   = $this->MyAjmer->newEntity();
            $myajmer   = $this->MyAjmer->patchEntity($myajmer, $this->request->data);

            $myajmer->created_at = date('Y-m-d H:i:s');
                if ($this->MyAjmer->save($myajmer)) {
                    $_resultflag = true;
                    $message = __('Successfully saved.');
                } else {
                    $_resultflag = false;
                    $message = __('Given Detail has not been saved due to some error.');
                }        
        }else{
                $_resultflag = false;
                $message = __('Data already exist.');            
        }    
        $this->set(compact('_resultflag', 'message'));
        $this->set('_serialize', ['_resultflag', 'message']);
    }
    
    public function deletemyajmer($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        
        $favouriteList = $this->MyAjmer->find('all')->where(['MyAjmer.user_id' => $this->request->data['user_id'],'MyAjmer.ajmer_type' => $this->request->data['ajmer_type'],'MyAjmer.favourite_type_ids' => $this->request->data['favourite_type_ids']]);
        $asfavouriteList =  $favouriteList->toArray();
        if(!empty($asfavouriteList)){
            $id  = $asfavouriteList[0]->id;
            $MyAjmer = $this->MyAjmer->get($id);
            if ($this->MyAjmer->delete($MyAjmer)) {
                $_resultflag = true;
                $message = __('Record deleted successfully.');
            } else {
                $_resultflag = false;
                $message = __('Record could not be deleted. Please, try again.');
            }
        }else{
                $_resultflag = true;
                $message = __('Record not found.');            
        }
        $this->set(compact('_resultflag', 'message'));
        $this->set('_serialize', ['_resultflag', 'message']);
    }

    
}
