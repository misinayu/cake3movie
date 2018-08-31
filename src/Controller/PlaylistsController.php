<?php
namespace App\Controller;

use App\Controller\AppController;

class PlaylistsController extends AppController{

	public function index(){
		$this->paginate = [
				'contain' => ['Users'],
		];
		$playlists = $this->paginate($this->Playlists);
		$this->set(compact('playlists'));
	}

	public function view(){
		$this->autoRender = FALSE;
		$result = [];
		$movie_list = [];

		if($this->request->is(['ajax'])){
			$playlist_id = $this->request->data['playlist_id'];
			$movies = $this->Playlists->Movies->find('list', [
					'conditions' => ['playlist_id' => $playlist_id],
					'order' => ['order_num' => 'ASC']
			]);
			foreach($movies as $m){
				$movie_list[] = $m;
			}
			$result['status'] = "success";
			$result['movies'] = $movie_list;
			echo json_encode($result);
			return;
		}
		$result['status'] = "error";
		echo json_encode($result);
	}
}