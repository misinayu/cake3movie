<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class PlaylistsController extends AppController{
	
	public function index(){
		$user_id = $this->MyAuth->user("id");
		$this->paginate = [
				'contain' => ['Users'],
// 				'conditions' => ['user_id' => $user_id]
		];
		$playlists = $this->paginate($this->Playlists);
		$this->set(compact('playlists'));
	}
	
	public function add(){
		$playlist = $this->Playlists->newEntity();
		$user_id = $this->MyAuth->user("id");
		if($this->request->is('post')){
			
// 			$playlist->name = $this->request->data['name'];
			$playlist = $this->Playlists->patchEntity($playlist, $this->request->data);
			$playlist->user_id = $user_id;
			if($this->Playlists->save($playlist)){
				$this->Flash->success(__('プレイリストの作成が完了しました'));
				return $this->redirect(['action' => 'index']);
			}
			dump($playlist);
			$this->Flash->error(__('プレイリストの作成が失敗しました'));
		}
		$this->set(compact('playlist'));
	}
	
	public function edit($playlist_id = null){
		$user_id = $this->MyAuth->user("id");
		$playlist = $this->Playlists->get($playlist_id, [
				'conditions' => [
						'user_id' => $user_id
				]
		]);
		
		if(isset($playlist) && !empty($playlist)){
			if($this->request->is(['patch', 'post', 'put'])){
				$playlist = $this->Playlists->patchEntity($playlist, $this->request->data);
				if($this->Playlists->save($playlist)){
					$this->Flash->success(__('プレイリスト情報を更新しました'));
					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('プレイリスト情報の更新に失敗しました'));
			}
		}else{
			$this->Flash->error(__('あなたのプレイリストではありません'));
			return $this->redirect(['action' => 'index']);
		}
		
		$this->set(compact('playlist'));
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