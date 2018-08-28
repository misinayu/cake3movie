<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class HomesController extends AppController{
	
	public function index(){
		if($this->request->is(['patch', 'post', 'put'])){
			
		}
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