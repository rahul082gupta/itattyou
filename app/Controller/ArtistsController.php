<?php
	/**
	* @author Rahul Gupta
	*/
	class ArtistsController extends AppController {

		public function profile($id = null) {
			if($id) {
				$url = 'https://www.youtube.com/watch?v=JtZa58nP2Qo&v=ghjd';

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
								'ArtistVideo' => array('fields' => array('video', 'type')),
							)
						)
					);
				}
				if(isset($artistInfo['ArtistVideo']) && $artistInfo['ArtistVideo']) {
					foreach($artistInfo['ArtistVideo'] as &$video) {
						if($video['type'] == 1) {
							$url = explode('&',$video['video']);
							$v_id = explode('=',$url['0']);
							$video['video'] = 'http://youtube.com/embed/'.$v_id['1'];
						}
					}
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