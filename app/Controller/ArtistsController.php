<?php
	/**
	* @author Rahul Gupta
	*/
	class ArtistsController extends AppController {

		public function profile($id = null) {
			if($id) {
				$id = base64_decode($id);
				$this->layout = 'public';
				if(!$this->Artist->exists($id)) {
					$this->Session->setFlash(__('Sorry, This artist is not visible. Please, try again.',
	                    'default', array(), 'bad'));
					$this->redirect(array('controller' => 'users' ,'action' => 'profile'));
				} else {
					$artistInfo = $this->Artist->find('first',
						array(
							'conditions' => array(
								'Artist.id' => $id
							),
							'contain' => array(
								'ArtistArt' => array('fields' => array('image')),
								'ArtistVideo' => 'video'
							)
						)
					);
				}
				$this->set('artistInfo', $artistInfo);
			} else {
				$this->Session->setFlash(__('Invalid request. Please, try again.',
	                    'default', array(), 'bad'));
				$this->redirect(array('controller' => 'users' ,'action' => 'profile'));
			}
		}
	}
?>