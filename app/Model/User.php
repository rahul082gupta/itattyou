<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
	class User extends AppModel{

		public function beforeSave($options = array()) {
	        if (!empty($this->data[$this->alias]['password'])) {
	            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
	            $this->data[$this->alias]['password'] = $passwordHasher->hash(
	                $this->data[$this->alias]['password']
	            );
	        }
	        return true;
	    }

	   	public $hasMany = array(
	    	'UserArt' => array(
	    		'className' => 'UserArt',
	    		'foreignkey' => 'user_id'
    		),
    		'UserVideo' => array(
	    		'className' => 'UserVideo',
	    		'foreignkey' => 'user_id'
    		)
    	);
	}
?>