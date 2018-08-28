<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;

class HomesController extends AppController{
	
	public function index(){
		$user_id = $this->MyAuth->user('id');
		$this->Playlists = TableRegistry::get('Playlists');
		$playlists = $this->Playlists->find('list',
				['conditions' => ['user_id' => $user_id]]);
		
		$this->set(compact('playlists'));
	}
	
	public function indexajax(){
		$this->autoRender = FALSE;
		$result = [];
		
		if($this->request->is(['ajax'])){
			$result['status'] = "success";
			$result['search'] = $this->request->data['search'];
			echo json_encode($result);
			return;
		}
		$result['status'] = "error";
		echo json_encode($result);
	}
}