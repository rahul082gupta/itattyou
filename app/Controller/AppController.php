<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array('Minify.Minify', 'Form', 'Session', 'Html');
	public $components = array(
            'DebugKit.Toolbar', 'Session',
            'Auth' => array(
                    'loginAction' => array('controller' => 'Users', 'action' => 'signup'),
                    'loginRedirect' => array('controller' => 'Users', 'action' => 'profile'),
                    'logoutRedirect' => array('controller' => 'Users', 'action' => 'signup'),
                    'authError' => 'For your security, this part of the website is protected.  Please enter your username and password to procced.  Thank You!";
',
                    'authenticate'      => array(
                        'Form' 
                    )
            )
        );
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->loginError = "Invalid login/password.  Please try again."; 
    }

	public function validEmail($email)
	{
		$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
		$ret="false";
		if (eregi($pattern, $email))
		{
			$ret="true";
		}
		return($ret);			
	}

	public function send_email($subject, $template, $to, $type, $arrvars, $from = null, $cc = null, $attachments=null, $bcc = null) {
        $Email = new CakeEmail();
        $Email->emailFormat($type);
        $Email->config('default');           
        if($from) {
            $Email->from(array('donotreply@ittatyou.com' => $from));    
        } else {
            $Email->from(array('donotreply@ittatyou.com' => __('Itattyou Customer Care')));    
        }
        
        $Email->to($to);
        if($cc) {
            $Email->cc($cc);
        }

        if($bcc) {
            $Email->bcc($bcc);
        }

        if($attachments) {
            $Email->attachments($attachments);    
        }

        $Email->subject(__($subject));
        $Email->template($template);  
        $Email->viewVars($arrvars);

        if(!$Email->send()){
        	echo $this->Email->smtpError;die;
        }
        return $Email->returnPath();
    }
}
