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
								'ArtistFollower' => array('follower_id', 'id'), 
								'ArtistFollowing' => array('following_id', 'id'),
								'Tatoo' => array('name', 'id')
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

		public function follow() {
			$result = array('status' => '0', 'error' => 'Invalid request.Please try again.');
			if($this->request->data) {
				$data = $this->request->data;
				if(!$data['id'] && $data['type'] == 0 && $data['userid']) {
					$follerinfo = array('follower_id' => $this->Auth->user('id'), 'user_id' => $data['userid']);
					$this->Artist->ArtistFollower->save($follerinfo);
					$artist_follower = $this->Artist->ArtistFollower->find('count', array(
								'conditions' => array(
									'ArtistFollower.user_id' => $data['userid']
								)
							)
					);
					$result = array('status' => '1', 'id' => $this->Artist->ArtistFollower->id, 'val' => '1'
						, 'count' => $artist_follower, 'button' => 'Following');
				}elseif($data['id'] && $data['userid']) {
					$this->Artist->ArtistFollower->delete($data['id']);
					$artist_follower = $this->Artist->ArtistFollower->find('count', array(
								'conditions' => array(
									'ArtistFollower.user_id' => $data['userid']
								)
							)
					);
					$result = array('status' => '1', 'id' => '', 'val' => '0', 'count' => $artist_follower
						, 'button' => 'Follow');
				}
			}
			$this->set('result', $result);
        	$this->set('_serialize', array('result'));
		}
	}
?>