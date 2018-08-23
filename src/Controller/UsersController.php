<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController{
	public function initialize(){
		parent::initialize();
		// ユーザ登録とログインのために「MyAuth」を利用する
		$this->loadComponent("MyAuth");
		// 以下のアクションのみはアクセス可能にする
		$this->MyAuth->allow(["login", "register"]);
	}
	
	public function login(){
		$user = $this->Users->newEntity();
		if($this->request->is('post')){
			// IDとパスワードの妥当性をチェックする
			$user = $this->MyAuth->identify();
			if($user){
				// 正当なユーザなのでセッションに代入
				$this->MyAuth->setUser($user);
				// ログイン後のURLへリダイレクト
				return $this->redirect($this->MyAuth->redirectUrl());
			}else{
				$this->Flash->error(__('ID、またはパスワードが間違っています'));
			}
		}
		// ログイン画面を表示
		$this->set(compact('user'));
	}
	
	public function register(){
		$user = $this->Users->newEntity();
		if($this->request->is('post')){
			// リクエストデータに基づく新規ユーザ作成
			$user = $this->Users->patchEntity($user, $this->request->data);
			if($this->Users->save($user)){
				// ユーザ作成と同時にセッションに代入
				$this->MyAuth->setUser($user);
				$this->Flash->success("ユーザ登録が完了しました");
				// ログイン後の画面へリダイレクト
				return $this->redirect($this->MyAuth->redirectUrl());
			}
			$this->Flash->error(__('ユーザ登録に失敗しました'));
		}
		// ユーザ作成画面を表示
		$this->set(compact('user'));
	}
}