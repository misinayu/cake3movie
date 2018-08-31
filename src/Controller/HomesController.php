<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class HomesController extends AppController{

	public function index(){
		
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