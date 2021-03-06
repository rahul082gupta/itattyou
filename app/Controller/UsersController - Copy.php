<?php
	class UsersController extends AppController {

	    public $components = array('Hybridauth');
		public function beforeFilter() {
			parent::beforeFilter();
			$this->Auth->allow('signup', 'activate', 'validate_user_reg_ajax', 'login', 'validate_user_login_ajax', 'social_login', 'social_endpoint');
		}
     

		public function signup() {
			$this->layout = 'public';
			$title_for_layout = __('Signup');	
			if ($this->request->is('post')) {
				if(!empty($this->request->data)) {	
					$error=array();
					$error=$this->validate_user_reg($this->request->data);
					if(count($error)==0) {
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
					} else {
						$this->set('error',$error);
					}
			    }
	        }
			$this->set(compact('title_for_layout'));
		}

		function validate_user_reg_ajax()
		{
			
			$this->layout="";
			$this->autoRender=false;
			if($this->request->is('ajax'))
			{
				$errors_msg = null;
				$errors=$this->validate_user_reg($this->request->data);
							
				if ( is_array ( $this->request->data ) )
				{
					foreach ($this->data['User'] as $key => $value )
					{
						if( array_key_exists ( $key, $errors) )
						{
							foreach ( $errors [ $key ] as $k => $v )
							{
								$errors_msg .= "error|$key|$v";
							}		
						}
						else 
						{
							$errors_msg .= "ok|$key\n";
						}
					}
				}
				echo $errors_msg;
				die;
			}	
		}

		function validate_user_reg($data)
		{		
			$errors = array ();
			if(trim($data['User']['name']==""))
			{
				$errors['name'] []= __(FIELD_REQUIRED,true)."\n";
			}
			if(trim($data['User']['username']==""))
			{
				$errors['username'] []= __(FIELD_REQUIRED,true)."\n";
			}
			elseif(trim($data['User']['username'])!="")
			{
				$checkexistEmail=$this->User->find('count',array('conditions'=>array('username'=>$data['User']['username'])));	
				if($this->validEmail($data['User']['username'])=='false')
				{
					$errors['username'] []=__(INVALID_EMAIL,true)."\n";
				}
				elseif($checkexistEmail>0)
				{
					$errors ['username'] [] = __(EMAIL_EXISTS,true)."\n";	
				}
			}
			
			if(trim($data['User']['password']==""))
			{
				$errors ['password'] [] = __(FIELD_REQUIRED,true)."\n";
			}
			elseif(strlen(trim($data['User']['password']))<6)
			{
				$errors['password'][]= __(PASSWORD_LENGTH_VALIDATION,true)."\n";
			}
			return $errors;
			
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
					$error=array();
					$error=$this->validate_user_login($this->request->data);
					if(count($error)==0) { 
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
					   
					} else {
						$this->set('error',$error);
					}
			    }
	        }
			$this->set(compact('title_for_layout'));
		}

		function validate_user_login_ajax()
		{
			
			$this->layout="";
			$this->autoRender=false;
			if($this->request->is('ajax'))
			{
				$errors_msg = null;
				$errors=$this->validate_user_login($this->request->data);
							
				if ( is_array ( $this->request->data ) )
				{
					foreach ($this->data['User'] as $key => $value )
					{
						if( array_key_exists ( $key, $errors) )
						{
							foreach ( $errors [ $key ] as $k => $v )
							{
								$errors_msg .= "error|$key|$v";
							}		
						}
						else 
						{
							$errors_msg .= "ok|$key\n";
						}
					}
				}
				echo $errors_msg;
				die;
			}	
		}

		function validate_user_login($data)
		{		
			$errors = array (); 
			if(trim($data['User']['username']==""))
			{
				$errors['username'] []= __(FIELD_REQUIRED,true)."\n";
			}
			elseif(trim($data['User']['username'])!="")
			{
				$checkexistEmail=$this->User->find('count',array('conditions'=>array('username'=>$data['User']['username'])));	
				if($this->validEmail($data['User']['username'])=='false')
				{
					$errors['username'] []=__(INVALID_EMAIL,true)."\n";
				}
				elseif(!$checkexistEmail)
				{
					$errors ['username'] [] = __(EMAIL_NOT_EXIST,true)."\n";	
				}
			}
			
			if(trim($data['User']['password']=="")) {
				$errors ['password'] [] = __(FIELD_REQUIRED,true)."\n";
			}elseif(strlen(trim($data['User']['password']))<6) {
				$errors['password'][]= __(PASSWORD_LENGTH_VALIDATION,true)."\n";
			}
			if($this->Auth->login($data)) {
			//echo 'ji'.$this->Auth->user('id');die;
			} else {
		//echo $this->Auth->loginError;die; 	
			}
			return $errors;
			
		}

		public function profile() {
			$this->layout = 'public';
			if(!empty($this->request->data)) {	
					$error=array();
					$error=$this->validate_user_reg($this->request->data);
					if(count($error)==0) {
						
						$this->User->create();
						$dob = $this->request->data['User']['yy'].'-'.$this->request->data['User']['mm'].'-'.$this->request->data['User']['dd'];
					    $this->request->data['User']['dob'] = $db;
						pr($this->request->data);die;
					    if ($this->User->save($this->request->data)) {
					    	$id = $this->User->id;
					    	$this->Session->setFlash(__('Profile updated successfully.'), 'default', array(), 'good'); 
				    		$this->redirect( array('controller' => 'Users', 'action' => 'my_profile'));
					    }else {
					    	$this->Session->setFlash(__('Unable to Save. Sorry we are having trouble.  Please, try again or contact support.',
                    'default', array(), 'bad'));
						}
					} else {
						$this->set('error',$error);
					}
			    }if (empty($this->data)) {
					$this->data = $this->User->read(null, $id);
					//pr($this->data);die;
					$this->set('id',$this->data['User']['id']);
		}
			
		}

		public function page() {
			$this->layout = 'public';

		}

		public function fblogin() {
			// check user is not logged in
			if($this->Auth->loggedIn() ) {
				$facebook_id = $this->Facebook->isLoggedIn();
	            if($facebook_id) {
	            	list($facebook_id, $name)= explode('-', $facebook_id);
	            	$user_fbinfo = $this->Facebook->processFacebookRequest('/'.$facebook_id);
	                if($user_fbinfo['status']) {
	                	$userInfo = $this->User->findBySocialId($user_fbinfo['message']['id']);
	                	if($userInfo) {
	                		$this->Auth->login($userInfo['User']); 
                		} else {

	                	}
	                	$this->redirect(array('controller' => 'Users', 'action' => 'profile'));
	                	

	                } else {
	                	$this->Session->setFlash(__('Sorry, your facebook profile is not accessible.Please try again.'), 'default', array(), 'bad'); 
				    	$this->redirect(array('controller' => 'Users', 'action' => 'signup'));
	                }
	        	} else {
	                $login_url = $this->Facebook->fbLogin(HTTP_ROOT.'/Users/fblogin');
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
              die('sdf');
		// #1 - check if user already authenticated using this provider before
		$this->SocialProfile->recursive = -1;
		$existingProfile = $this->SocialProfile->find('first', array(
			'conditions' => array('social_network_id' => $incomingProfile['SocialProfile']['social_network_id'], 'social_network_name' => $provider)
		));
		
		if ($existingProfile) {
			// #2 - if an existing profile is available, then we set the user as connected and log them in
			$user = $this->User->find('first', array(
				'conditions' => array('id' => $existingProfile['SocialProfile']['user_id'])
			));
			
			$this->_doSocialLogin($user,true);
		} else {
			
			// New profile.
			if ($this->Auth->loggedIn()) {
				// user is already logged-in , attach profile to logged in user.
				// create social profile linked to current user
				$incomingProfile['SocialProfile']['user_id'] = $this->Auth->user('id');
				$this->SocialProfile->save($incomingProfile);
				
				$this->Session->setFlash('Your ' . $incomingProfile['SocialProfile']['social_network_name'] . ' account is now linked to your account.');
				$this->redirect($this->Auth->redirectUrl());

			} else {
				// no-one logged and no profile, must be a registration.
				$user = $this->User->createFromSocialProfile($incomingProfile);
				$incomingProfile['SocialProfile']['user_id'] = $user['User']['id'];
				$this->SocialProfile->save($incomingProfile);

				// log in with the newly created user
				$this->_doSocialLogin($user);
			}
		}	
	}
	
	private function _doSocialLogin($user, $returning = false) {

		if ($this->Auth->login($user['User'])) {
			if($returning){
				$this->Session->setFlash(__('Welcome back, '. $this->Auth->user('username')));
			} else {
				$this->Session->setFlash(__('Welcome to our community, '. $this->Auth->user('username')));
			}
			$this->redirect($this->Auth->loginRedirect);
			
		} else {
			$this->Session->setFlash(__('Unknown Error could not verify the user: '. $this->Auth->user('username')));
		}
	}

        //END OF CODE

	}
?>