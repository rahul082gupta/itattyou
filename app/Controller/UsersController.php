<?php
	class UsersController extends AppController {
	
		public function beforeFilter() {
			parent::beforeFilter();
			$this->Auth->allow('signup', 'activate', 'validate_user_reg_ajax', 'login', 'validate_user_login_ajax');
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
			
		}

	}
?>