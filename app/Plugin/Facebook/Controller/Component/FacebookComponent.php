<?php
/**
 * FacebookComponent
 *
 * Provides an entry point into the Facebook SDK.
 */

require_once __DIR__ . '/../../Vendor/autoload.php';


use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser; 
//session_start();
class FacebookComponent extends Component {
	public $facebookObj;
	public $facebookSession;
	public function startup(Controller $controller) {
	    $this->Controller = $controller;
	}

	
	// public function facebookRequest(string $httpMethod = 'GET', string $path, array $params = NULL, string $version = NULL) {
	public function facebookRequest($requestParams = "") {
		$fbaccesstoken = Configure::read("fbaccesstoken");
		// Make a new request and execute it.
		$response = array('status' => 0, 'message' => 'Request Can not process.Please try again.');
		FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);

		$this->facebookSession = new FacebookSession($fbaccesstoken);

		// To validate the session:
		try {
			$this->facebookSession->validate();
			// Make a new request and execute it.
			try {
				$response = (new FacebookRequest($this->facebookSession, 'GET', $requestParams, array('scope' => 'user_status, publish_stream, user_photos, user_events, manage_pages,user_videos')))->execute()->getGraphObject()->asArray();
				$response = json_decode(json_encode($response),true);
				$response = array('status' => 1, 'message' => $response);
			} catch (FacebookRequestException $ex) {
		  		$response = array('status' => 0, 'message' => $ex->getMessage());
			} catch (Exception $ex) { 
		 		$response = array('status' => 0, 'message' => $ex->getMessage());
			}
		  
		} catch (FacebookRequestException $ex) {
		  // Session not valid, Graph API returned an exception with the reason.
	  		echo $ex->getMessage();
		} catch (\Exception $ex) {
		  // Graph API returned info, but it may mismatch the current app or have expired.
	  		echo $ex->getMessage();
		}
		return $response;
	}

	public function fbLogin($returnURL) { 
		$login_success = false;
		$helper = new FacebookRedirectLoginHelper($returnURL, APP_ID, APP_SECRET);
		FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);
		try {
		    $session = $helper->getSessionFromRedirect();
		} catch(FacebookRequestException $ex) { 
		    $session = null;
		} catch(\Exception $ex) { echo $ex->getMessage();
		    $session = null;
		}
		
		if ($session) { 
			$_SESSION['accessToken'] = $session->getToken();
		} else {
		  $this->Controller->redirect($helper->getLoginUrl(array('user_status, publish_stream, user_photos, user_events, manage_pages,user_videos,read_stream')));
		}
	}

	public function isLoggedIn()
	{
	    $id=0;
	    FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);  
	    if(isset($_SESSION['accessToken']))
	    {	
	        $session = new FacebookSession( $_SESSION['accessToken'] );
		    // Validate the access_token to make sure it's still valid
		    try {
		        if ( ! $session->validate() ) { 
		            $session = null;
		        }else {
		        	
		        }
		    } catch ( Exception $e ) {
		        // Catch any exceptions
		        $session = null;
		        unset($_SESSION['accessToken']);
		    }
		    if($session) { 
		    	$check_permission = $this->checkPermission($session);
		    	if($check_permission){
			    	$request = new FacebookRequest($session, 'GET', '/me?fields=id,name');
					$pageList = $request->execute()->getGraphObject()->asArray(); 
					$pageList = json_decode(json_encode($pageList),true);
					$id = $pageList['id'].'-'.$pageList['name'];
				}
		    }
	        
	    }
	    return $id;
	}

	public function processFacebookRequest($requestParams = "") {
		// Make a new request and execute it.
		FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);
		$response = array('status' => 0, 'message' => 'Request Can not process.Please try again.');
		if(isset($_SESSION['accessToken'])) {
			$this->facebookSession = new FacebookSession($_SESSION['accessToken']);

			// To validate the session:
			try {
				$this->facebookSession->validate();
				// Make a new request and execute it.
				try {
					//pr($this->facebookSession->getSessionInfo());
					$response = (new FacebookRequest($this->facebookSession, 'GET', $requestParams,array('scope' => 'user_status, publish_stream, user_photos, user_events, manage_pages,user_videos')))->execute()->getGraphObject()->asArray(); //echo 'ji';pr($response);die;

					$response = json_decode(json_encode($response),true);
					$response = array('status' => 1, 'message' => $response);
				} catch (FacebookRequestException $ex) {
			  		$response = array('status' => 0, 'message' => $ex->getMessage());
				} catch (Exception $ex) { 
			 		$response = array('status' => 0, 'message' => $ex->getMessage());
				}
			  
			} catch (FacebookRequestException $ex) {
			  // Session not valid, Graph API returned an exception with the reason.
		  		echo $ex->getMessage();
			} catch (\Exception $ex) {
			  // Graph API returned info, but it may mismatch the current app or have expired.
		  		echo $ex->getMessage();
			}
		}
		return $response;
	}

	public function FbLogout($next_url)
	{ 
	   
	    $helper = new FacebookRedirectLoginHelper($next_url, APP_ID, APP_SECRET);
	    FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);  
	    if(isset($_SESSION['accessToken']))
	    {	
	        $session = new FacebookSession($_SESSION['accessToken']);
	         unset($_SESSION['accessToken']);
	        $this->Controller->redirect($helper->getLogoutUrl($session, $next_url));
	    }
	}

	public function checkPermission($session) {
		$profile_permissions = array('user_status', 'public_profile', 'user_photos', 'user_events', 'manage_pages','user_videos'); 
		$permissions = $session->getSessionInfo()->asArray();
		$permissions = $permissions['scopes'];
    	$i = 0;
    	if($permissions){
    		foreach($profile_permissions as $profile_permission) { 
    			if(!in_array($profile_permission, $permissions)) { 
    				$i++;
    			}
    		}
    	}
    	if($i) {
    		$request = new FacebookRequest(
			  $session,
			  'DELETE',
			  '/me/permissions'
			);
			$response = $request->execute();
			$graphObject = $response->getGraphObject();
    		return false;
    	}else {
    		return true;
    	}
	}
}