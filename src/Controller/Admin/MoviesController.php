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
			foreach($movies as $m){
				if($movie->video_id === $m->video_id){
					$result['status'] = 'error';
					$result['errors'] = 'もうその動画は入ってます';
					echo json_encode($result);
					return;
				}
			}
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
	
		if($this->request->is(['ajax'])){
			$playlist_id = $this->request->data['playlist_id'];
			$video_id = $this->request->data['video_id'];
			$movies = $this->paginate($this->Movies, [
					'order' => ['order_num' => 'asc'],
					'conditions' => ['playlist_id' => $playlist_id]
			]);
			
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
				$movies = $this->Movies->find('list', [
						'conditions' => ['playlist_id' => $playlist_id],
						'order' => ['order_num' => 'asc']
				]);
				$idlist = [];
				foreach($movies as $key => $value){
					$idlist[] = $value;
				}
				$result['status'] = "success";
				$result['movies'] = $idlist;
				echo json_encode($result);
				return;
			}
		}
	
		$result['status'] ="error";
		echo json_encode($result);
	}
	
	public function up(){
		$this->autoRender = FALSE;
		$result = [];
		
		if($this->request->is(['ajax'])){
			$playlist_id = $this->request->data['playlist_id'];
			$video_id = $this->request->data['video_id'];
			$movies = $this->paginate($this->Movies, [
					'conditions' => ['playlist_id' => $playlist_id],
					'order' => ['order_num' => 'asc']
			]);
			
			foreach($movies as $movie){
				if($movie->video_id === $video_id &&
						$movie->playlist_id === (int)$playlist_id){
					if($movie->order_num <= 0){
						$result['status'] = "error";
						$result['errors'] = "並び順を変更できません";
						echo json_encode($result);
						return;
					}
					
					$prev = $this->Movies->find('all', [
							'conditions' => [
									'order_num' => $movie->order_num -1,
									'playlist_id' => $playlist_id
							]
					]);
					foreach($prev as $p){
						$p->order_num++;
						if($this->Movies->save($p)){
							
						}else{
							$result['status'] = "error";
							$result['errors'] = "前の動画の並び替えができない";
							echo json_encode($result);
							return;
						}
					}
					$movie->order_num--;
					if($this->Movies->save($movie)){
						
					}else{
						$result['status'] = "error";
						$result['errors'] = "今の動画の並び替えができない";
						echo json_encode($result);
						return;
					}
				}
			}
			$movies = $this->Movies->find('list', [
					'conditions' => ['playlist_id' => $playlist_id],
					'order' => ['order_num' => 'asc']
			]);
			$idlist = [];
			foreach($movies as $value){
				$idlist[] = $value;
			}
			$result['status'] = "success";
			$result['movies'] = $idlist;
			echo json_encode($result);
			return;
		}
		$result['status'] ="error";
		echo json_encode($result);
	}
	
	public function down(){
		$this->autoRender = FALSE;
		$result = [];
		
		if($this->request->is(['ajax'])){
			$playlist_id = $this->request->data['playlist_id'];
			$video_id = $this->request->data['video_id'];
			$movies = $this->paginate($this->Movies, [
					'conditions' => ['playlist_id' => $playlist_id],
					'order' => ['order_num' => 'asc']
			]);
			
			$b = false;
			foreach($movies as $movie){
				if($b){
					//次の動画の順番を上げる
					$movie->order_num--;
					if($this->Movies->save($movie)){
						break;
					}else{
						$result['status'] = "error";
						$result['errors'] = "次の動画の並び替えができない";
						echo json_encode($result);
						return;
					}
				}
				
				if($movie->video_id === $video_id &&
						$movie->playlist_id === (int)$playlist_id){
					if($movie->order_num >= count($movies)-1){
						$result['status'] = "error";
						$result['errors'] = "並び順を変更できません";
						echo json_encode($result);
						return;
					}
					
					$movie->order_num++;
					if($this->Movies->save($movie)){
						$b = true;
					}else{
						$result['status'] = "error";
						$result['errors'] = "今の動画の並び替えができない";
						echo json_encode($result);
						return;
					}
				}
			}
			$movies = $this->Movies->find('list', [
					'conditions' => ['playlist_id' => $playlist_id],
					'order' => ['order_num' => 'asc']
			]);
			$idlist = [];
			foreach($movies as $value){
				$idlist[] = $value;
			}
			$result['status'] = "success";
			$result['movies'] = $idlist;
			echo json_encode($result);
			return;
		}
		$result['status'] ="error";
		echo json_encode($result);
	}
}