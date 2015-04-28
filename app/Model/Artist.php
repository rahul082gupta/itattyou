<?php
App::uses('AppModel', 'Model');
	class Artist extends AppModel {

		public $useTable = 'users';
		public $actsAs = array('containable');
	   	public $hasMany = array(
	    	'ArtistArt' => array(
	    		'className' => 'UserArt',
	    		'foreignkey' => 'user_id'
    		),
    		'ArtistVideo' => array(
	    		'className' => 'UserVideo',
	    		'foreignkey' => 'follower_id'
    		),
    		'ArtistFollower' => array(
	    		'className' => 'UserFollower',
	    		'foreignkey' => 'user_id'
    		),
    		'ArtistFollowing' => array(
	    		'className' => 'UserFollowing',
	    		'foreignkey' => 'user_id'
    		),
    	);
	}
?>