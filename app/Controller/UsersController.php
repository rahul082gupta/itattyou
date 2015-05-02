<?php
	class UsersController extends AppController {

	    public $components = array('Hybridauth');
		public function beforeFilter() {
			parent::beforeFilter();
			$this->Auth->allow('signup', 'activate', 'login', 
			 'social_login', 'social_endpoint', 'checkemail');
		}
     

		public function signup() {
			$this->layout = 'public';
			$title_for_layout = __('Signup');	
			if ($this->request->is('post')) {
				if(!empty($this->request->data)) {
					$this->User->create();
					if(!isset($this->request->data['User']['role'])) {
					$this->request->data['User']['role'] = 1;
					}
					if ($this->User->save($this->request->data)) {
					  	$id = $this->User->id;
					   	$this->sendActivationEmail( $this->request->data['User']['name'],
					    $id,  $this->request->data['User']['username']);
					    $this->Session->setFlash(__('Welcome to itattyou. We sent you an email to verify your account. Please click the activation link there before your next login.'), 'default', array(), 'good'); 
				    	$this->redirect( array('controller' => 'Users', 'action' => 'login'));
					}else {
					    $this->Session->setFlash(__('Unable to Save. Sorry we are having trouble.  Please, try again or contact support.',
                    'default', array(), 'bad'));
					}
					
			    }
	        }
			$this->set(compact('title_for_layout'));
		}

		public function sendActivationEmail ($name, $id, $email) {
			$arrvars['name'] = $name;
			$arrvars['link'] = HTTP_ROOT.'Users/activate?id='.$id.'&token='.$this->getActivationHash($id);
			$subject="Thank you for choosing itattyou, $name ";
			$template='register';
			$to = $email;
			$type = 'html';
			$this->send_email($subject, $template, $to, $type, $arrvars);	
		}

		function activate(){
			if (isset($this->request->query['id']) && isset($this->request->query['token'])) {
				$hash = $this->getActivationHash($this->request->query['id']);
				if($hash==trim($this->request->query['token'])){
					$this->User->id = $this->request->query['id'];
	    			$this->User->save(array('User'=>array('status'=> 1)));
	    			$this->Session->setFlash(__('Your account is now active, Please login to start building your profile ... '),
	    			 'default', array(), 'good');
					$this->redirect( array('controller' => 'Users', 'action' => 'login'));
				}else{
					throw new NotFoundException();
				}			
			} else {
				throw new NotFoundException();
			}
		}

		function getActivationHash($id = null) {
	        if ($id || isset($this->id)) {
	        	if (!$id) { $id = $this->id; }
	        	return substr(Security::hash(Configure::read('Security.salt') . $id . date('Ymd')), 0, 8);    
	        }
	        return false;
		}

		public function sendForgotPassEmail ($id, $email) {
			$Email = new CakeEmail();
			$Email->emailFormat('both');
			$Email->config('default');				
			$Email->from(array('donotreply@snaplion.com' => __('SnapLion Customer Care')));
			$Email->to($email);
			$Email->subject(__('Password reset instructions'));
			
			$link = $this->getActivationLink($id); 
			$Email->send(__('Please click on the link below to reset your password').' <br /><br /><a href="'.
				$link.'">'.$link.'</a>');die;
		}

		private function getActivationLink($id) {
			return	FULL_BASE_URL.'/users/reset_pass?id='.$id.'&token='.$this->getActivationHash($id);

		}

		public function login() {
			$this->layout = 'public';
			$title_for_layout = __('Login');	
			if ($this->request->is('post')) {
				if(!empty($this->request->data)) {
					$checkuser = $this->User->find('count',
						array(
							'conditions' => array(
								'User.username' => $this->request->data['User']['username']
							)
						));
					if($checkuser) {
						if($this->Auth->login()) {
							if ($this->Auth->user('status') != 1) {
								$this->sendActivationEmail($this->Auth->user('name'), $this->Auth->user('id'), $this->Auth->user('username'));
								$this->Session->setFlash(__('Sorry, your account is not active yet.  Please check your email for our account confirmation link, or contact support'), 'default', array(), 'bad'); 
				    		} else {
				    			$this->redirect(array('controller' => 'Users', 'action' => 'profile'));
				    		}
						} else {
							$this->Session->setFlash($this->Auth->loginError, 'default', array(), 'bad'); 
				    	}
			    	}
			    } else {
			    	$this->Session->setFlash(__('Invalid request.Please try again'), 'default', array(), 'bad'); 
			    }
	        }
			$this->set(compact('title_for_layout'));
		}

		public function profile() { 
			$this->loadModel('Tatoo');
			$this->layout = 'public';
			$this->User->recursive = -1;
	    	$this->request->data = $this->User->read(null, $this->Session->read('Auth.User.id'));
	    	$tatoos = $this->Tatoo->find('list');
	    	if($this->request->data['User']['dob']) {
	    		list($this->request->data['User']['yy'],$this->request->data['User']['mm'], 
	    			$this->request->data['User']['dd']) = explode('-', $this->request->data['User']['dob']);
	    	}
	    	$this->set('tatoos', $tatoos);
		}
		public function profile_save() {
			$result = array('status' => '0', 'msg' => 'Invalid request.Please try again.');
			if(!empty($this->request->data)) {
				if(isset($this->request->data['User']['yy'])) {
					$dob = $this->request->data['User']['yy'].'-'.$this->request->data['User']['mm'].'-'.
					$this->request->data['User']['dd'];
				    $this->request->data['User']['dob'] = $dob;
				}
			    if ($this->User->save($this->request->data)) { 
			    	$this->request->data = array_merge($this->Auth->user(), $this->request->data['User']);
			    	$this->Auth->login($this->request->data);
			    	$result = array('status' => '1', 'msg' => 'Profile Saved.Please upload your image','name' =>
			    		$this->request->data['name']);
			    }else {
			    	$result = array('status' => '0', 'msg' => 'Unable to Save. Sorry we are having trouble.  
			    		Please, try again or contact support');
				}
				
			}	
			$this->set('result', $result);
        	$this->set('_serialize', array('result')); 
			
		}

		public function page() {
			$this->layout = 'public';

		}

		public function fblogin() {
			// check user is not logged in
			if(!$this->Auth->loggedIn() ) {
				$facebook_id = $this->Facebook->isLoggedIn();
	            if($facebook_id) {
	            	list($facebook_id, $name)= explode('-', $facebook_id);
	            	$user_fbinfo = $this->Facebook->processFacebookRequest('/'.$facebook_id);
	                if($user_fbinfo['status']) {
	                	$userInfo = $this->User->findByFacebookId($user_fbinfo['message']['id']);
	                	
	                	if($userInfo) {
	                		$this->Auth->login($userInfo['User']); 
                		} else {
                			$facebookdata['name'] = $user_fbinfo['message']['name'];
                			$facebookdata['facebook_id'] = $user_fbinfo['message']['id'];
                			$this->User->save($facebookdata);
                			$this->Auth->login($facebookdata); 
                			$this->Session->write('Auth.User.id', $this->User->id);
	                	}
	                	
	                	$this->redirect(array('controller' => 'Users', 'action' => 'profile'));
	                	

	                } else {
	                	$this->Session->setFlash(__('Sorry, your facebook profile is not accessible.Please try again.'), 'default', array(), 'bad'); 
				    	$this->redirect(array('controller' => 'Users', 'action' => 'signup'));
	                }
	        	} else {
	                $login_url = $this->Facebook->fbLogin(HTTP_ROOT.'Users/fblogin');
	                die;
	            }
           	} else {
           		$this->redirect(array('controller' => 'Users', 'action' => 'profile'));
           	}
		}

		public function edit($id = null) {
			if (!$id) {
				$this->Session->setFlash('Please provide a user id');
				$this->redirect(array('action'=>'index'));
			}

			$user = $this->User->findById($id);
			if (!$user) {
				$this->Session->setFlash('Invalid User ID Provided');
				$this->redirect(array('action'=>'index'));
			}

			if ($this->request->is('post') || $this->request->is('put')) {
				$this->User->id = $id;
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been updated'));
					$this->redirect(array('action' => 'edit', $id));
				}else{
					$this->Session->setFlash(__('Unable to update your user.'));
				}
			}

			if (!$this->request->data) {
				$this->request->data = $user;
			}
		}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}
        
        //START  GOOGLE LOGIN
         	/* social login functionality */
	public function social_login($provider) {
		if( $this->Hybridauth->connect($provider) ){
			$this->_successfulHybridauth($provider,$this->Hybridauth->user_profile);
        }else{
            // error
			$this->Session->setFlash($this->Hybridauth->error);
			$this->redirect($this->Auth->loginAction);
        }
	}

	public function social_endpoint($provider) {
		$this->Hybridauth->processEndpoint();
	}
	
	private function _successfulHybridauth($provider, $incomingProfile){
       // #1 - check if user already authenticated using this provider before
		
		$this->User->recursive = -1;
		$existingProfile = $this->User->find('first', array(
			'conditions' => array('social_network_id' => $incomingProfile['SocialProfile']['social_network_id'])
		));
		//pr($incomingProfile);die;
		if ($existingProfile) {
			// #2 - if an existing profile is available, then we set the user as connected and log them in
			$user = $this->User->find('first', array(
				'conditions' => array('id' => $existingProfile['User']['id'])
			));
			
			$this->_doSocialLogin($user,true);
		} else {
			// New profile.
			if ($this->Auth->loggedIn()) {
				// user is already logged-in , attach profile to logged in user.
				// create social profile linked to current user
				$incomingProfile['User']['id'] = $this->Auth->user('id');
				$incomingProfile['User']['name'] = $incomingProfile['SocialProfile']['first_name'];
				$incomingProfile['User']['email'] = $incomingProfile['SocialProfile']['email'];
				$incomingProfile['User']['photo'] = $incomingProfile['SocialProfile']['picture'];
				$this->User->save($incomingProfile);
				$this->Session->setFlash(__('Your ' . $incomingProfile['SocialProfile']['social_network_name'] . ' account is now linked to your account.'),
	                    'default', array(), 'good');
				$this->redirect($this->Auth->redirectUrl());

			} else {
				// no-one logged and no profile, must be a registration.
				//$user = $this->User->createFromSocialProfile($incomingProfile);
				//$incomingProfile['SocialProfile']['id'] = $incomingProfile['User']['id'];
				$incomingProfile['User']['id'] = 11;
				$incomingProfile['User']['username'] = $incomingProfile['SocialProfile']['first_name'];
				$incomingProfile['User']['email'] = $incomingProfile['SocialProfile']['email'];
				$incomingProfile['User']['social_network_id'] = $incomingProfile['SocialProfile']['social_network_id'];
				//pr($incomingProfile);die;
				$this->User->save($incomingProfile);
                // pr($user);die;
				// log in with the newly created user
				$this->_doSocialLogin($incomingProfile);
			}
		}	
	}
	
	private function _doSocialLogin($user, $returning = false) {

		if ($this->Auth->login($user['User'])) {
			if($returning){
				$this->Session->setFlash(__('Welcome back, '. $this->Auth->user('username')) ,
                    'default', array(), 'good');
			} else {
				$this->Session->setFlash(__('Welcome to our community, '. $this->Auth->user('username')));
			}
			$this->redirect($this->Auth->loginRedirect);
			
		} else {
			$this->Session->setFlash(__('Unknown Error could not verify the user: '. $this->Auth->user('username')));
		}
	}

    //END OF CODE

    public function checkemail() {
    	$this->autoRender = false;
    	$this->autoLayout = false;
    	$data = $this->request->query;
    	$result = array($data['fieldId'], 0, 'Invalid request.');
    	if(isset($data['fieldValue'])) {
	    	$checkexistEmail=$this->User->find('count',array('conditions'=>array('username'=>$data['fieldValue'])));	
			if($this->validEmail($data['fieldValue'])=='false')
			{
				$result = array($data['fieldId'], 0, INVALID_EMAIL);
			}
			elseif($checkexistEmail)
			{
				$result = array($data['fieldId'], 0, EMAIL_EXISTS); 
			}else {
				$result = array($data['fieldId'], 1); 
			}
		}
		echo json_encode($result);
    }

}
?>