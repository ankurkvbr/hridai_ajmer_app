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
class CraftFoodController extends AppController
{
	
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null */
	 
	 public function initialize(){
		
		parent::initialize();
		$this->Auth->allow(['craftfoodlist','getmap']); 
		 
	 }
	
	 public function craftfoodlist() {
        $this->request->allowMethod(['post']);
        $_resultflag = false;
        $message = __('Record Not Found!');
		$limit = Configure::read('page.limit');

        $path = $this->request->webroot.Configure::read('webroot.img')."craftfood/";
         
        $this->request->query += $this->request->data;
		$category = isset($this->request->data['category']) ? $this->request->data['category'] : '';
		//print_r($category);exit;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
        $image_path = "http://" . $_SERVER['SERVER_NAME'] .$path;
        
        $this->loadModel('CraftFoodImages');
		
		if($category != ''){
			$craftfoods = $this->CraftFood->find();
			//$craftfoods = $this->CraftFood->find('all')->order(['CraftFood.id'=>'DESC']) ==> Display sort_order wise listing
			$craftfoods = $this->CraftFood->find('all')->order(['CraftFood.sort_order'=>'ASC'])
					
					->select(['CraftFood.id', 
							'CraftFood.title',
							'CraftFood.description',
							'CraftFood.short_description',
							'CraftFood.latitude',
							'CraftFood.address',
							'CraftFood.longitude',
							'CraftFood.latitude',
							'CraftFood.sort_order',
							])
					->contain(['CraftFoodImages' => function($q){
						$q->select([
							'CraftFoodImages.id',
							'CraftFoodImages.image',
							'CraftFoodImages.craft_food_id',
						]);
						$q->order(['CraftFoodImages.shorting_order' =>'ASC']);
						return $q;
					}])
					->contain(['CraftFoodImages' => [
						'fields' => [
								'CraftFoodImages.id', 
								'CraftFoodImages.image', 
								'CraftFoodImages.craft_food_id']]
					])
					->where(['CraftFood.is_active' => 1])
					->where(['CraftFood.category' => $category])
					->hydrate(false);
			//debug($craftfoods);exit;
			$asEvents =  $craftfoods->toArray();
			//pr($asEvents);exit();
			$total_records = count($asEvents);
			if(empty($total_records))
			{
				$_resultflag = true;
				$message = __('Record Not Found');
			}
			
			try {
				$CraftfoodsData = $this->paginate($craftfoods,array('limit'=>$limit));
			} catch (NotFoundException $e) {
				$CraftfoodsData = [];
			}
			if (!empty($CraftfoodsData) && $CraftfoodsData->count() > 0) {
				$_resultflag = true;
				$message = __('Success');
			}
		} else{
            $_resultflag = false;
            $favouriteList = '';
            $message = __('Missing required parameter');
            $this->set(compact('_resultflag', 'message'));
            $this->set('_serialize', ['_resultflag', 'message']);
        }
        $this->set(compact('_resultflag', 'message','total_records', 'image_path', 'craftfoods'));
        $this->set('_serialize', ['_resultflag', 'message','total_records', 'image_path', 'craftfoods']);
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
        
        $path = $this->request->webroot.Configure::read('webroot.img')."craftfood/";

        $this->request->query += $this->request->data;
		
		//print_r($category);exit;
        if (!empty($this->request->data['lang']) && $this->request->data['lang'] != 'en') {
            I18n::locale($this->request->data['lang']);
        }
        $image_path = "http://" . $_SERVER['SERVER_NAME'] .$path;
		$craftfoods = $this->CraftFood->find('all');		
		
		//new library used
        $craftfoods = $this->CraftFood->find('all')
				->select([
						'CraftFood.id', 
						'CraftFood.title',
						'CraftFood.description',
						'CraftFood.short_description',
						'CraftFood.latitude',
						'CraftFood.address',
						'CraftFood.longitude',
						'CraftFood.latitude',
				])
                ->contain(['CraftFoodImage' => [
					'fields' => [
							'CraftFoodImage.id', 
							'CraftFoodImage.image', 
							'CraftFoodImage.craft_food_id']]
				])
				->where(['latitude <=' => $maxlat, 'latitude >=' => $minlat])
				->andWhere(['longitude <=' => $maxlng, 'longitude >=' => $minlng])
                                ->where(['CraftFood.is_active' => 1]);
				
        $asEvents =  $craftfoods->toArray();
        $total_records = count($asEvents);
		if(empty($total_records))
		{
			$_resultflag = true;
			$message = __('Record Not Found');
		}
        
        try {
            $CraftfoodsData = $this->paginate($craftfoods,array('limit'=>$limit));
        } catch (NotFoundException $e) {
            $CraftfoodsData = [];
        }
        if (!empty($CraftfoodsData) && $CraftfoodsData->count() > 0) {
            $_resultflag = true;
            $message = __('Success');
        }
        $this->set(compact('_resultflag', 'message','total_records', 'image_path', 'craftfoods'));
        $this->set('_serialize', ['_resultflag', 'message','total_records', 'image_path', 'craftfoods']);
    }
	
}
