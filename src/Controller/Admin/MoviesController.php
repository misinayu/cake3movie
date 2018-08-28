<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class MoviesController extends AppController{
	
	public function add(){
		$this->autoRender = FALSE;
		$result = [];
// 		$this->loadModel('PlaylistMovies');
		$movie = $this->Movies->newEntity();
		
		if($this->request->is('ajax')){
			$movie->playlist_id = $this->request->data('playlist_id');
			$movie->video_id = $this->request->data('video_id');
			$movie->order_num = 0;
			if($this->Movies->save($movie)){
				$result['status'] = 'success';
				echo json_encode($result);
				return;
			}
// 			$result['status'] = 'success';
// 			echo json_encode($result);
// 			return;
		}
		$result['status'] = 'error';
		echo json_encode($result);
	}
}