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

class FeedbackController extends AppController {

    public function initialize() {
        parent::initialize();
		$this->loadModel('Tokens');
        $this->Auth->allow(['getfeedbacklist','addfeedback']);
    }

    /**
     * REST API for Event List
     * @return get feedback list
     */
    public function getfeedbacklist() {
        $this->request->allowMethod(['post']);
       // $_resultflag = false;
      //  $message = __('Record Not Found!');
        $limit = Configure::read('page.limit');

       // $this->request->query += $this->request->data;
        $Feedback = $this->Feedback->find('all',array('order'=>array('Feedback.id'=>'desc')))
                ->select(['Feedback.id','Feedback.user_id','Feedback.feedback_for_id','Feedback.feedback_for_id','Feedback.feedback_category_id','Feedback.rating','Feedback.description','Feedback.created_at','first_name'=>'User.first_name','last_name'=>'User.last_name'])
             //   ->contain(['User' => ['fields' => ['Users.name']]])
                 ->join([
                        'table' => 'users',
                        'alias' => 'User',
                        'type' => 'INNER',
                        'conditions' => array('User.id = Feedback.user_id')
                    ])
                ->where(['Feedback.feedback_for_id = 1'])
                ->hydrate(false);

        $asFeedback = $Feedback->toArray();

        $total_records = count($asFeedback);
        if (empty($total_records)) {
            $_resultflag = true;
            $message = __('Record Not Found');
        }


        try {
            $FeedbackData = $this->paginate($Feedback, array('limit' => $limit));
        } catch (NotFoundException $e) {
            $FeedbackData = [];
        }
        if (!empty($FeedbackData) && $FeedbackData->count() > 0) {
            $_resultflag = true;
            $message = __('Success');
            $i = 0;
            foreach($asFeedback as $feedbackdetail){
                $asFDetail[$i]['id'] = $feedbackdetail['id'];
                $asFDetail[$i]['user_id'] = $feedbackdetail['user_id'];
                $asFDetail[$i]['name'] = $feedbackdetail['first_name'].' '.$feedbackdetail['last_name'];
                $asFDetail[$i]['feedback_for_id'] = $feedbackdetail['feedback_for_id'];
                $asFDetail[$i]['feedback_category_id'] = $feedbackdetail['feedback_category_id'];
                $asFDetail[$i]['rating'] = $feedbackdetail['rating'];
                $asFDetail[$i]['description'] = $feedbackdetail['description'];
                $asFDetail[$i]['created_at'] = $feedbackdetail['created_at'];
                $i++;
            }
        }
        $this->set(compact('_resultflag', 'message', 'total_records', 'asFDetail'));
        $this->set('_serialize', ['_resultflag', 'message', 'total_records', 'asFDetail']);
    }
    
    
    
    /**
     * REST API for Event List
     * @return get feedback list
     */
    public function addfeedback() {
        $this->request->allowMethod(['post']);

        $feedback   = $this->Feedback->newEntity();
		if ($this->request->is('post')) {
			
			$feedback   = $this->Feedback->patchEntity($feedback, $this->request->data);
			$param_token = isset($this->request->data['rand_token'])?$this->request->data['rand_token']:'';
			$decRandomToken = $this->CryptAes->decryption($param_token);
			if($decRandomToken){
				extract($decRandomToken);
				$userDevice = $this->Tokens->find('all')->where(['user_id = ' => $uid, 'device_id =' => $device_id, 'token' => $token])->first();
				//$asdevice = $userDevice->toArray();
				if(empty($userDevice))
				{
					$_resultflag = false;
					$message = __('Invalid token, Please try again !!');
					
				} else{
					$feedback->user_id = $uid;
					$feedback->created_at = date('Y-m-d H:i:s');
					if ($this->Feedback->save($feedback)) {
						$_resultflag = true;
						$message = __('The feedback has been saved.');
					} else {
						$_resultflag = false;
						$message = __('The feedback has not been saved due to some error.');
					}	
				}
			} else {
				$_resultflag = false;
				$message = __('Invalid token, Please try again !!');
			}			
			$this->set(compact('_resultflag', 'message'));
			$this->set('_serialize', ['_resultflag', 'message']);
		}
    }

}
