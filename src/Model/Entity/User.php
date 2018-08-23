<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use cake\Auth\Cake\Auth;

class User extends Entity{
	protected $_accessible = [
			'*' => true,
			'id' => false
	];
	
	protected $_hidden = [
			'password'
	];
	
	// オブジェクトにパスワードの値が設定されたときにハッシュ化して設定する
	protected function _setPassword($password){
		return (new DefaultPasswordHasher)->hash($password);
	}
}