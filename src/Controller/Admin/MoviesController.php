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
			$movies = $categories = $this->paginate($this->Movies, [
					'conditions' => [
							'playlist_id' => $movie->playlist_id 
					]
			]);
			$movie->order_num = count($movies);
			if($this->Movies->save($movie)){
				$result['status'] = 'success';
				echo json_encode($result);
				return;
			}
		}
		$result['status'] = 'error';
		echo json_encode($result);
	}
	
	public function delete(){
		$this->autoRender = FALSE;
		$result = [];
		$movie = $this->Movies->newEntity();
		$movies = $this->paginate($this->Movies, [
				'order' => ['order_num' => 'asc']
		]);
	
		if($this->request->is(['ajax'])){
			$playlist_id = $this->request->data['playlist_id'];
			$video_id = $this->request->data['video_id'];
			$isDel = false; //削除した要素の次の番号から-1をするための、判断をする変数
			foreach ($movies as $m){
				if(($m->playlist_id === (int)$playlist_id) &&
						($m->video_id === $video_id) && !$isDel){
					$movie = $m;
					$isDel = true;
				}
				if($isDel){
					$m->order_num--;
					if($this->Movies->save($m)){
						
					}else{
						$result['status'] ="error";
					}
				}
			}
			if($this->Movies->delete($movie)){
				$result['status'] ="success";
				echo json_encode($result);
				return;
			}
		}
	
		$result['status'] ="error";
		echo json_encode($result);
	}
	
	public function up(){
		
	}
	
	public function down(){
		
	}
}