<?php

namespace App\Controller\Api;

use Cake\Core\Configure;
use App\Controller\Api\AppController;
use Cake\I18n\I18n;
use Cake\Network\Exception\NotFoundException;
use Cake\Collection\Collection;

/**
 * Event Controller
 *
 * @property \App\Model\Table\EventTable $Event
 */
class MyAjmerController extends AppController {

    public function initialize() {
        parent::initialize();
		$this->loadModel('Tokens');
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
		$objRs = '';
		$objResult = array();
		$asList = array();
		
		$pathEvent = $this->request->webroot . Configure::read('webroot.img') . "event/";
		$pathMonument = $this->request->webroot.Configure::read('webroot.img')."monumentsgardens/";
		
        $this->request->query += $this->request->data;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
		
		$param_token = isset($this->request->data['rand_token'])?$this->request->data['rand_token']:'';
		$decRandomToken = $this->CryptAes->decryption($param_token);
		
		if($decRandomToken){
			
			extract($decRandomToken);
			$userDevice = $this->Tokens->find('all')->where(['user_id = ' => $uid, 'device_id =' => $device_id, 'token' => $token])->first();
			if(empty($userDevice))
			{
				$_resultflag = false;
				$message = __('Invalid token, Please try again !!');
				$this->set(compact('_resultflag', 'message'));
				$this->set('_serialize', ['_resultflag', 'message']);
				
			} else{
				
				$userId = isset($uid) ? $uid : '';
				$ajmer_type = isset($this->request->data['ajmer_type']) ? $this->request->data['ajmer_type'] : '';
				
				$this->loadModel('Event');
				$this->loadModel('MonumentsGardens');
				$this->loadModel('MonumentsGardensImages');
				$this->loadModel('MonumentRating');
				$this->loadModel('MonumentReview');
			
				if($userId != '' && $ajmer_type != '' ){
					
					$image_path = "http://" . $_SERVER['SERVER_NAME'] . $pathEvent;
					
					if($ajmer_type == '1'){
					
						$Events = $this->Event->find('all')
								->select([//'MyAjmer.id',
								  //'MyAjmer.user_id',
								 // 'first_name' 			=> 'User.first_name',
								 // 'ajmertype'  			=> "IF(MyAjmer.ajmer_type = '1', 'Event', 'Monument Garden')",
								 // 'favourite_type_id'	=> "IF(MyAjmer.ajmer_type = '1', Event.event_name, '')",
								  'Event.id',
								  'Event.event_name',
								  'Event.event_description',
								  'Event.address','Event.latitude',
								  'Event.longitude',
								  'Event.even_date_time',
								  'Event.state_id',
								  'Event.city_id',
								  'city_name' => 'Cities.name',
								  'state_name' => 'States.name'])
					   
						->contain(['EventImages' => function($q){
							$q->select([
								'EventImages.id',
								'EventImages.image',
								'EventImages.event_id',
							]);
							$q->order(['EventImages.shorting_order' =>'ASC']);
							return $q;
						}])
						->contain(['Cities'])
						->contain(['States'])
						->join([
							'p' => [
								'table' => 'my_ajmer',
								'alias' => 'MyAjmer',
								'type' => 'INNER',
								'conditions' => array(
												'MyAjmer.user_id' => $userId, 
												'MyAjmer.favourite_type_ids = Event.id'
											)
							],
							'u' => [
								'table' => 'users',
								'alias' => 'User',
								'type' => 'INNER',
								'conditions' => array('User.id = MyAjmer.user_id')
							]
						])
						->where(['Event.is_active' => 1])->hydrate(false);
						$objRs = 'event';
						$objResult = $Events;
						$asList = $Events->toArray();
					
					}elseif($ajmer_type == '2'){
						
						$image_path = "http://" . $_SERVER['SERVER_NAME'] . $pathMonument;
						$audio_path = "http://" . $_SERVER['SERVER_NAME'] . $this->request->webroot.Configure::read('webroot.img')."monumentsgardens_audio/";
						$audio_cover_image_path = "http://" . $_SERVER['SERVER_NAME'] . $this->request->webroot.Configure::read('webroot.img')."monumentsgardens_audio_cover_image/";
						
						$Monuments = $this->MonumentsGardens->find();
						$Monuments = $this->MonumentsGardens->find('all')->order(['MonumentsGardens.id'=>'DESC'])
								->select(['MonumentsGardens.id', 
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
									'audio_cover_image' => 'MonumentsGardens.audio_cover_image'
								])->where(['MonumentsGardens.is_active' => 1])
								->join([
									'a' => [
										'table' => 'my_ajmer',
										'alias' => 'MyAjmer',
										'type' => 'INNER',
										'conditions' => array(
														'MyAjmer.user_id' => $userId, 
														'MyAjmer.favourite_type_ids = MonumentsGardens.id'
													)
									],
									'b' => [
										'table' => 'users',
										'alias' => 'User',
										'type' => 'INNER',
										'conditions' => array('User.id = MyAjmer.user_id')
									]
								])
								->contain(['MonumentsGardensImages' => function($q){
									$q->select([
										'MonumentsGardensImages.id',
										'MonumentsGardensImages.image',
										'MonumentsGardensImages.monument_id',
									]);
									$q->order(['MonumentsGardensImages.shorting_order' =>'ASC']);
									return $q;
								}])
								->contain(['MonumentsGardensImages' => ['fields' => ['MonumentsGardensImages.id', 
									'MonumentsGardensImages.image', 'MonumentsGardensImages.monument_id']]])
								->contain(['MonumentReview' => function($q){
									$q->select([
										'MonumentReview.monument_id',
										'ratingAvg' => $q->func()->avg('MonumentReview.rating'),
										'totalReview' => $q->func()->count('MonumentReview.monument_id')
									]);
									$q->where(['MonumentReview.is_publish' => 1]);
									$q->group(['MonumentReview.monument_id']);
									return $q;
								},'Cities','States']);
								//->hydrate(false);
								
								$objRs = 'monument';
								$objResult = $Monuments;
								$asList =  $Monuments->toArray();
					}
					
					$total_records = count($asList);
					
					if (empty($total_records)) {
						$_resultflag = true;
						$message = __('Record Not Found');
					}
					try {
						if(count($objResult) > 0){
							$myAmjerData = $this->paginate($objResult, array('limit' => $limit));	
						}
					} catch (NotFoundException $e) {
						$myAmjerData = [];
					}
					if (isset($myAmjerData) && !empty($myAmjerData) && $myAmjerData->count() > 0) {
						
						if($objRs == 'monument'){
							
							$collection = new Collection($Monuments);
							$Monuments = $collection->filter(function ($f) {
								//RatingAvg Total Review
									$ratingAvg = $totalReview = 0;
									if (!empty($f['monument_review'])) {
										//$ratingAvg = ceil($f['monument_review'][0]['ratingAvg']);
										$ratingAvg = $this->getRatingValue($f['monument_review'][0]['ratingAvg']);
										$totalReview = $f['monument_review'][0]['totalReview'];

										unset($f['monument_review'][0]['ratingAvg']);
										unset($f['monument_review'][0]['totalReview']);
									}
									unset($f['monument_review']);
									$f['ratingAvg'] = $ratingAvg;
									$f['totalReview'] = $totalReview; 
									
									//Youtube Video thumb image link 
									if (!empty($f['video_thumb'])) {
										parse_str( parse_url( $f['video_thumb'], PHP_URL_QUERY ), $videoVars );
										if(!empty($videoVars['v'])){
											$f['video_thumb'] = 'https://img.youtube.com/vi/'.$videoVars['v'].'/default.jpg';
										} else {
											$f['video_thumb'] = '';
										}
									}
								
									
								return $f;
							});
						}
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
				
				if($objRs == 'monument'){
					$this->set(compact('_resultflag', 'message', 'total_records', 'image_path', 'audio_path','audio_cover_image_path', 'Monuments'));
					$this->set('_serialize', ['_resultflag', 'message', 'total_records', 'image_path', 'audio_path','audio_cover_image_path','Monuments']);
				} elseif($objRs == 'event'){
					$this->set(compact('_resultflag', 'message', 'total_records', 'image_path', 'audio_path','audio_cover_image_path', 'Events'));
					$this->set('_serialize', ['_resultflag', 'message', 'total_records', 'image_path', 'audio_path','audio_cover_image_path','Events']);	
				}	
			}
		} else {
			$_resultflag = false;
			$message = __('Invalid token, Please try again !!');
			$this->set(compact('_resultflag', 'message'));
			$this->set('_serialize', ['_resultflag', 'message']);
		}
    }
	
	/**
     * REST API for Event List
     * @return get ajmer list
     */
    public function addmyajmer() {
		
        $this->request->allowMethod(['post']);
		if(isset($this->request->data['favourite_type_ids'])){
			$this->request->data['favourite_type_ids'] = (int) $this->request->data['favourite_type_ids'];	
		}
		
		$param_token = isset($this->request->data['rand_token'])?$this->request->data['rand_token']:'';
		
		$decRandomToken = $this->CryptAes->decryption($param_token);
		
		if($decRandomToken){
			
			extract($decRandomToken);
			$userDevice = $this->Tokens->find('all')->where(['user_id = ' => $uid, 'device_id =' => $device_id, 'token' => $token])->first();
			if(empty($userDevice))
			{
				$_resultflag = false;
				$message = __('Invalid token, Please try again !!');
					
			} else{
				
				$favouriteList = $this->MyAjmer->find('all')->where(['MyAjmer.user_id' => $uid,'MyAjmer.ajmer_type' => $this->request->data['ajmer_type'],'MyAjmer.favourite_type_ids' => $this->request->data['favourite_type_ids']]);
				
				if(empty($favouriteList->toArray())){
					$myajmer   = $this->MyAjmer->newEntity();
					$myajmer   = $this->MyAjmer->patchEntity($myajmer, $this->request->data);
					$myajmer->user_id = $uid;
					$myajmer->created_at = date('Y-m-d H:i:s');
					
						if ($this->MyAjmer->save($myajmer)) {
					
							$_resultflag = true;
							$message = __('Successfully saved.');
						} else {
						
							$_resultflag = false;
							$message = __('Given Detail has not been saved due to some error.');
						}        
				} else{
						$_resultflag = false;
						$message = __('Already saved.');            
				}
			}
		} else {
				$_resultflag = false;
				$message = __('Invalid token, Please try again !!');
		}		
        $this->set(compact('_resultflag', 'message'));
        $this->set('_serialize', ['_resultflag', 'message']);
    }
    
    public function deletemyajmer($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        
		$param_token = isset($this->request->data['rand_token'])?$this->request->data['rand_token']:'';
		
		$decRandomToken = $this->CryptAes->decryption($param_token);
		
		if($decRandomToken){
			
			extract($decRandomToken);
			$userDevice = $this->Tokens->find('all')->where(['user_id = ' => $uid, 'device_id =' => $device_id, 'token' => $token])->first();
			if(empty($userDevice))
			{
				$_resultflag = false;
				$message = __('Invalid token, Please try again !!');	
			} else{
				
				$favouriteList = $this->MyAjmer->find('all')->where(['MyAjmer.user_id' => $uid,'MyAjmer.ajmer_type' => $this->request->data['ajmer_type'],'MyAjmer.favourite_type_ids' => $this->request->data['favourite_type_ids']]);
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
				} else{
					$_resultflag = true;
					$message = __('Record not found.');            
				}
			}	
		} else {
			$_resultflag = false;
			$message = __('Invalid token, Please try again !!');
		}	
        $this->set(compact('_resultflag', 'message'));
        $this->set('_serialize', ['_resultflag', 'message']);
    }
	
	public function getRatingValue($val) {
		
		$value = number_format($val,2);
		$value = explode(".",$value);
		
		if($value[1] != 00 && $value[1] <= 50){
			$value[1] = 50;
		} else{
			if($value[0] == 5){
				$value[0] = 5;		
			}else{
				$value[0] = $value[0] + 1;	
			}
			$value[1] = 0;
		}	
		
		$newVal = implode(".", $value);
		return (float)$newVal;
	}
    
}
