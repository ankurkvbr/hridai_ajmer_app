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
class MonumentsGardensController extends AppController
{
	
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null */
	 
	 public function initialize(){
		
		parent::initialize();
		$this->Auth->allow(['getmonumentslist','monumentlist','getmap','monumentInteractive']); 
		 
	 }
	 
	 
     
  /*  public function getmonumentslist()
    {
	
        //$this->request->allowMethod(['post']);
		$_resultflag = false;
		$message = __('Record Not Found!');	
		$limit = Configure::read('page.limit');
		$path = $this->request->webroot.Configure::read('App.imageBaseUrl')."monument";
		$imagePath = "http://" . $_SERVER['SERVER_NAME'] .$path;
		/*$id = $this->request->data['id'];
		//$id = 1;
		
		if(!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en'){
			I18n::locale($this->request->data['lang']);
		} 
		/*$this->loadModel('MonumentsGardensImages');
		$this->loadModel('MonumentRating');
		$this->loadModel('MonumentReview');
		
		$monuments1 = $this->Monumentsgardens->find('all')
		->contain(['Cities'])
		->contain(['States']);
		
		
		$asmonuments1 = $monuments1->toArray();
		
		
		//$monuments->select(['count'=>$monuments->func()->count('id')])->first();
		$monumentsGardenImage = $this->MonumentsGardensImages->find('all')->where(['monument_id'=>$id])->order(['id'=>'DESC'])->first();
		$monumentsRating = $this->MonumentRating->find();
		$monumentsRating->select(['avg'=>$monumentsRating->func()->avg('rating')])->where(['monument_id'=>$id])->first();
		$monumentsReview = $this->MonumentReview->find();
		$monumentsReview->select(['count'=>$monumentsReview->func()->count('monument_id')])->where(['monument_id'=>$id])->first();
		
		$monuMentData = [];
		$i=0;
		/*foreach($monuments1 as $asmonuments1)
		{
		//pr($monuments);
		$i++;
		$monuMentData[$i]['title'] = $asmonuments1->title;
		$monuMentData[$i]['description'] = $asmonuments1->description;
		$monuMentData[$i]['category'] = $asmonuments1->category;
		$monuMentData[$i]['state_id'] = $asmonuments1->state_id;
		
		$monuMentData[$i]['cities_id'] = $asmonuments1->cities_id;
		//$monuMentData[$i]['city_name'] = $asmonuments1->Cities.name;
		$monuMentData[$i]['is_active'] = $asmonuments1->is_active;
		} */
		
		/*$monuMentData['imgName'] = $monumentsGardenImage->image;
		
		foreach($monumentsRating as $key => $value){
			$monuMentData['Rating_Avg'] = $value->avg;
		}
		foreach($monumentsReview as $key => $value){
			$monuMentData['Monument_Review_Count'] = $value->count;
		}*/
		//pr($monuMentData);
		//exit();
		/*$monuments->select([
					'title',
					'description',
					'category',
					'state_id',
					'cities_id',
					'is_active',
					'Image' => 'LeftJoinMonumentsGardensImages.image',
					'rating' =>'LeftJoinMonumentRating.rating',
					'ratingAvg' => $monuments->func()->avg('LeftJoinMonumentRating.rating'),
					'countReview'=> $monuments->func()->count('LeftJoinMonumentReview.monument_id'),
					])->contain(['LeftJoinMonumentsGardensImages','LeftJoinMonumentRating','LeftJoinMonumentReview'])
					->group(['LeftJoinMonumentReview.monument_id','Monumentsgardens.id','LeftJoinMonumentRating.monument_id','LeftJoinMonumentsGardensImages.image']); 
		*/
		/*$monuments->select([
					'title',
					'description',
					'category',
					'state_id',
					'cities_id',
					'is_active',
					'Image' => 'LeftJoinMonumentsGardensImages.image',
					'ratingAvg' => $monuments->func()->avg('LeftJoinMonumentRating.rating'),
					'countReview' => $monuments->func()->count('LeftJoinMonumentReview.monument_id'),
					])->contain(['LeftJoinMonumentReview','LeftJoinMonumentRating'])
					->group(['LeftJoinMonumentReview.monument_id','LeftJoinMonumentRating.monument_id']);
			//debug($monuments);exit();*/
			/* $total_count = count($asmonuments1);*/

		/* try {
		
			  $monuments1 = $this->paginate($monuments1,array('limit'=>$limit));
		} 
		catch (NotFoundException $e) {
			$monuments1 = [];
		}
		if (!empty($monuments1)) {
			$_resultflag = true;
			$message = __('Success');
		} 
		$this->set(compact('_resultflag','message','total_count','asmonuments1','monuMentData','image_path'));
		$this->set('_serialize', ['_resultflag','asmonuments1','total_count','monuMentData','image_path']);
		*/
		
		/*if(!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en'){
			I18n::locale($this->request->data['lang']);
		} 
		 $image_path = "http://" . $_SERVER['SERVER_NAME'] .$path;
		$monuments = $this->Monumentsgardens->find();
			$monuments->select([
				'id',
				'title',
				'description',
				'category',
				'state_id',
				'cities_id',
				'Cities.name',
				'States.name',
				'is_active',
				//'Image' => 'IF(LENGTH(LeftJoinMonumentsGardensImages.image),CONCAT("'.$imagePath.'","/",LeftJoinMonumentsGardensImages.image),"")',
				'LeftJoinMonumentsGardensImages.image',
				'ratingAvg' => $monuments->func()->avg('LeftJoinMonumentReview.rating'),
				'total' => $monuments->func()->count('LeftJoinMonumentReview.monument_id')
			])
			->contain(['LeftJoinMonumentsGardensImages',
				'LeftJoinMonumentReview',
				'Cities',
                'States',
				
			]);
			*/
			
		//debug($monuments);
		 
    /*    $total_records = count($monuments);
		try {
			$monuments = $this->paginate($monuments,array('limit'=>$limit));
		} catch (NotFoundException $e) {
			$monuments = [];
		}
		if (!empty($monuments)) {
			$_resultflag = true;
			$message = __('Success');
		}
		$this->set(compact('_resultflag','message','total_records','monuments','image_path'));
		$this->set('_serialize', ['_resultflag','message','total_records','monuments','image_path']);
		 	
    } */ 	
	
	 public function monumentlist() {
        $this->request->allowMethod(['post']);
        $_resultflag = false;
        $message = __('Record Not Found!');
        $limit = Configure::read('page.limit');
        
        $path = $this->request->webroot.Configure::read('webroot.img')."monumentsgardens/";
         
        $this->request->query += $this->request->data;
		//$category = $this->request->data['category']; 
		//print_r($category);exit;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
        $image_path = "http://" . $_SERVER['SERVER_NAME'] .$path;
        
        $audio_path = "http://" . $_SERVER['SERVER_NAME'] . $this->request->webroot.Configure::read('webroot.img')."monumentsgardens_audio/";
        $audio_cover_image_path = "http://" . $_SERVER['SERVER_NAME'] . $this->request->webroot.Configure::read('webroot.img')."monumentsgardens_audio_cover_image/";
        
        $monuments = $this->MonumentsGardens->find();
		//$Monuments = $this->MonumentsGardens->find('all')->order(['MonumentsGardens.id'=>'DESC']) => changes done  for ser_order wise display listing
		$Monuments = $this->MonumentsGardens->find('all')->order(['MonumentsGardens.sort_order'=>'ASC']) 
		/*->contain(['MonumentReview'=>['fields' => [
				'ratingAvg' => $monuments->func()->avg('MonumentReview.rating'),'MonumentReview.monument_id'
						]]])*/
				
                ->select(['MonumentsGardens.id', 'MonumentsGardens.title','MonumentsGardens.description','MonumentsGardens.latitude','MonumentsGardens.address', 'MonumentsGardens.longitude', 'MonumentsGardens.tour_title', 'MonumentsGardens.tour_video','MonumentsGardens.latitude', 'MonumentsGardens.longitude', 'MonumentsGardens.sort_order', 'video_thumb' => 'MonumentsGardens.tour_video', 'audio' => 'MonumentsGardens.audio', 'audio_cover_image' => 'MonumentsGardens.audio_cover_image'])
				->where(['MonumentsGardens.is_active' => 1])
                ->contain(['MonumentsGardensImages' => function($q){
					$q->select([
						'MonumentsGardensImages.id',
                                            'MonumentsGardensImages.image',
                                            'MonumentsGardensImages.monument_id',
                                            //'MonumentsGardensImages.shorting_order'
					]);
                                        $q->order(['MonumentsGardensImages.shorting_order' =>'ASC']);
					return $q;
				}])
                ->contain(['MonumentsGardensImages' => ['fields' => ['MonumentsGardensImages.id', 
				'MonumentsGardensImages.image', 'MonumentsGardensImages.monument_id']]])
				/*->contain(['monument_review' => ['fields' => 
									['monument_review.id', 
									//'MonumentReview.monument_id',
									'monument_review.title',
									'monument_review.review',
									'monument_review.rating',
						           'monument_review.monument_id'
									
									]
								]
							*/
				->contain(['MonumentReview' => function($q){
					$q->select([
						'MonumentReview.monument_id',
						'ratingAvg' => $q->func()->avg('MonumentReview.rating'),
						'totalReview' => $q->func()->count('MonumentReview.monument_id')
					]);
                                        $q->where(['MonumentReview.is_publish' => 1]);
					$q->group(['MonumentReview.monument_id']);
					return $q;
				}]);
               /* ->hydrate(false)*/;
		//debug($Monuments);exit;
        $asEvents =  $Monuments->toArray();
        $total_records = count($asEvents);
		if(empty($total_records))
		{
			$_resultflag = true;
			$message = __('Record Not Found');
		}
        
        try {
            $MonumentsData = $this->paginate($Monuments,array('limit'=>$limit));
        } catch (NotFoundException $e) {
            $MonumentsData = [];
        }
		if (!empty($MonumentsData) && $MonumentsData->count() > 0) {
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
				
			
            $_resultflag = true;
            $message = __('Success');
        }
      
        $this->set(compact('_resultflag', 'message','total_records', 'image_path', 'audio_cover_image_path','audio_path', 'Monuments'));
        $this->set('_serialize', ['_resultflag', 'message','total_records', 'image_path', 'audio_cover_image_path', 'audio_path', 'Monuments']);
    }
	
	public function getmap() {
        $this->request->allowMethod(['post']);
		$lat = $this->request->data['latitude'];
		$lng = $this->request->data(['longitude']);
		$radius = $this->request->data(['radius']);
		$earth_radius = 6371;
        $_resultflag = false;
		
			// latitude boundaries
				$maxlat = $lat + rad2deg($radius/$earth_radius);
				$minlat = $lat - rad2deg($radius/$earth_radius);
				
				
				
				
			// longitude boundaries (longitude gets smaller when latitude increases)
			$maxlng = $lng + rad2deg($radius/$earth_radius / cos(deg2rad($lat)));
			$minlng = $lng - rad2deg($radius/$earth_radius / cos(deg2rad($lat)));
			
			
			
        $message = __('Record Not Found!');
        //$limit = Configure::read('page.limit');
        
        $path = $this->request->webroot.Configure::read('webroot.img')."monumentsgardens/";
        $audio_path = "http://" . $_SERVER['SERVER_NAME'] . $this->request->webroot.Configure::read('webroot.img')."monumentsgardens_audio/";
        $audio_cover_image_path = "http://" . $_SERVER['SERVER_NAME'] . $this->request->webroot.Configure::read('webroot.img')."monumentsgardens_audio_cover_image/";

        $this->request->query += $this->request->data;
		
		//print_r($category);exit;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
        $image_path = "http://" . $_SERVER['SERVER_NAME'] .$path;
		$monuments = $this->MonumentsGardens->find('all');		
		
		//new library used
        $Monuments = $this->MonumentsGardens->find('all')
				->select([
					'MonumentsGardens.id',
					'MonumentsGardens.title',
					'MonumentsGardens.description',
					'MonumentsGardens.state_id',
					'MonumentsGardens.cities_id', 
					'city_name' => 'Cities.name',
					'state_name' =>'States.name',
					'MonumentsGardens.latitude',
                                        'MonumentsGardens.category',
					'MonumentsGardens.address',
					'MonumentsGardens.longitude',
                                        'audio' => 'MonumentsGardens.audio',
                                        'audio_cover_image' => 'MonumentsGardens.audio_cover_image'
				])
                ->contain(['MonumentsGardensImages' => [
					'fields' => [
						'MonumentsGardensImages.id', 
						'MonumentsGardensImages.image', 
						'MonumentsGardensImages.monument_id'
					]
				],'MonumentReview' => function($q){
					$q->select([
						'MonumentReview.monument_id',
						'MonumentReview.title',
						'MonumentReview.review',
						'ratingAvg' => $q->func()->avg('MonumentReview.rating'),
						'totalReview' => $q->func()->count('MonumentReview.monument_id')
					]);
					$q->group(['MonumentReview.monument_id']);
					$q->where(['MonumentReview.is_publish' => 1]);
					return $q;
				},'Cities','States'])
				->where(['latitude <=' => $maxlat, 'latitude >=' => $minlat])
				->andWhere(['longitude <=' => $maxlng, 'longitude >=' => $minlng])
                                ->where(['MonumentsGardens.is_active' => 1]);
				
        $asEvents =  $Monuments->toArray();
        $total_records = count($asEvents);
		if(empty($total_records))
		{
			$_resultflag = true;
			$message = __('Record Not Found');
		}
        
        try {
           // $Monuments = $this->paginate($Monuments,array('limit'=>$limit));
        } catch (NotFoundException $e) {
            $Monuments = [];
        }
        if (!empty($Monuments) && $Monuments->count() > 0) {
			$collection = new Collection($Monuments);
			$Monuments = $collection->filter(function ($f) {
				$ratingAvg = $totalReview = 0;
				if (!empty($f['monument_review'])) {
					//$ratingAvg = ceil($f['monument_review'][0]['ratingAvg']);
					$ratingAvg = $this->getRatingValue($f['monument_review'][0]['ratingAvg']);
					$totalReview = $f['monument_review'][0]['totalReview'];
					unset($f['monument_review']);
					//unset($f['monument_review'][0]['ratingAvg']);
					//unset($f['monument_review'][0]['totalReview']);
				}
				//unset($f['monument_review']);
				$f['ratingAvg'] = $ratingAvg;
				$f['totalReview'] = $totalReview;
				return $f;
			});
            $_resultflag = true;
            $message = __('Success');
        }
        $this->set(compact('_resultflag', 'message','total_records', 'image_path','audio_path','audio_cover_image_path', 'Monuments'));
        $this->set('_serialize', ['_resultflag', 'message','total_records', 'image_path','audio_path','audio_cover_image_path', 'Monuments']);
    }
	
	public function monumentInteractive() 
	{
       $this->request->allowMethod(['post']);
		$id = isset($this->request->data['monument_id']) ? $this->request->data['monument_id'] : "";
		$category = $this->request->data(['category']);
		
        $_resultflag = false;
		
			
		 $message = __('Record Not Found!');
        $limit = Configure::read('page.limit');
        
        $path = $this->request->webroot.Configure::read('webroot.img')."monument/";
		$thumb = "https://img.youtube.com/vi/";
        $this->request->query += $this->request->data;
		
		//print_r($category);exit;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
        //$image_path = "http://" . $_SERVER['SERVER_NAME'] .$path;
		$monuments = $this->MonumentsGardens->find('all')->order(['MonumentsGardens.created_at'=>'DESC']);
		
		//new library used
		//$str = 'vi/';
		if(empty($category) && empty($id))
		{
	
		
       $Monuments = $this->MonumentsGardens->find('all')->order(['MonumentsGardens.created_at'=>'DESC'])
		
				->select([
					'MonumentsGardens.id',
				
					'MonumentsGardens.tour_title',
					'MonumentsGardens.tour_video',
					'video_thumb' => 'MonumentsGardens.tour_video'
					
				])
				
                ->contain(['Cities','States']);
		}
		else
		{    
			
			 $Monuments = $this->MonumentsGardens->find('all')->order(['MonumentsGardens.created_at'=>'DESC'])
		
				->select([
					'MonumentsGardens.id',
				
					'MonumentsGardens.tour_title',
					'MonumentsGardens.tour_video',
					'video_thumb' => 'MonumentsGardens.tour_video'
					
				])
                 ->contain(['MonumentReview' => function($q){
					$q->select([
						'MonumentReview.monument_id',
						//'ratingAvg' => $q->func()->avg('MonumentReview.rating'),
						'totalReview' => $q->func()->count('MonumentReview.monument_id')
					]);
					$q->group(['MonumentReview.monument_id']);
					return $q;
				},'Cities','States'])
				->where(['MonumentsGardens.id' => $id]);
				//->andWhere(['monument_id'] => $id);
				
					$asEvents =  $Monuments->toArray();
					$total_records = count($asEvents);
					if(empty($total_records))
					{
						$_resultflag = true;
						$message = __('Record Not Found');
					}
			
		}
				  // print_r($Monuments);exit;
        //$asEvents =  $monuments->toArray();
       // $total_records = count($asEvents);
		
        $total_records = count($Monuments->toArray());
        try {
            $Monuments = $this->paginate($Monuments,array('limit'=>$limit));
        } catch (NotFoundException $e) {
            $Monuments = [];
        }
        if (!empty($Monuments) && $Monuments->count() > 0) {
			$collection = new Collection($Monuments);
			$Monuments = $collection->filter(function ($f) {
				//RatingAvg Total Review
					$ratingAvg = $totalReview = 0;
					if (!empty($f['monument_review'])) {
						//$ratingAvg = $f['monument_review'][0]['ratingAvg'];
						$totalReview = $f['monument_review'][0]['totalReview'];

						//unset($f['monument_review'][0]['ratingAvg']);
						unset($f['monument_review'][0]['totalReview']);
					}
					//unset($f['monument_review']);
					//$f['ratingAvg'] = $ratingAvg;
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
				
			
            $_resultflag = true;
            $message = __('Success');
        }
        $this->set(compact('_resultflag', 'message','total_records', 'image_path', 'Monuments'));
        $this->set('_serialize', ['_resultflag', 'message','total_records', 'image_path', 'Monuments']);
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
