<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

/**
 * Event Controller
 *
 * @property \App\Model\Table\EventTable $Event
 */
class MonumentReviewController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null */
	 
	 public function initialize(){
		parent::initialize();
		$this->loadModel('Tokens');
		$this->Auth->allow(['getmonumentreview','addmonument']);  
	}
	public function getmonumentreview()
	{
		$this->request->allowMethod(['post']);
		$_resultflag = false;
		$message = __('Record Not Found!');	
		$limit = Configure::read('page.limit') ;
		$this->request->query += $this->request->data;
		
		$monuments = $this->MonumentReview->find('all')->order(['MonumentReview.created_at'=>'DESC'])
						 ->select(['user_id','Username' => 'Users.First_name','title','email' => 'Users.email','review','rating','created_at'])
        				 ->contain(['Users'])
                         ->where(['monument_id'=> $this->request->data['monument_id'],'MonumentReview.is_publish' => 1]);
						 
		/* $this->paginate = [
			'fields' => ['user_id','Username' => 'Users.First_name','title','email' => 'Users.email','review','rating','created_at'],
			'contain' => array('Users'),
			'conditions' => ['monument_id'=> $this->request->data['monument_id']],
		]; */
		
		$total_records = $monuments->count();
		if(empty($total_records))
		{
			$_resultflag = true;
			$message = __('Record Not Found');
		}
		
		try {
			$monuments = $this->paginate($monuments,array('limit'=>$limit));
		} catch (NotFoundException $e) {
			$monuments = [];
		}
	
		if(!empty($monuments) && $monuments->count() > 0 ){
			$_resultflag = true;
			$message = __('Success');
		}
		$this->set(compact('_resultflag','message','monuments','total_records'));
		$this->set('_serialize', ['_resultflag','message','monuments','total_records']);  
	}


    public function addmonument() {
        $this->request->allowMethod(['post']);
        $review = $this->MonumentReview->newEntity();
        $data = $this->request->data;

        if ($this->request->is('post')) {
			
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
				
					$review = $this->MonumentReview->patchEntity($review, $data);
					$review->user_id = $uid;
					$review->created_at = date('Y-m-d H:i:s');
					$review->is_publish = 0;

					if ($this->MonumentReview->save($review)) {
						$_resultflag = true;
						$message = __('Review added successfully');
					} else {
						$_resultflag = false;
						$message = __('System error occurred, please try again.');
					}
				}	
			} else{
				$_resultflag = false;
				$message = __('Invalid token, Please try again !!');
			}	
        }
        $this->set(compact('_resultflag', 'message'));
        $this->set('_serialize', ['_resultflag', 'message']);
    }

}