<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CommentsTable extends Table{
	public function initialize(array $config){
		parent::initialize($config);
		$this->table('comments');
		$this->displayField('id');
		$this->primaryKey('id');
		
		$this->addBehavior('Timestamp');
	}
	
	public function validationDefault(Validator $validator){
		$validator
			->integer('id')
			->allowEmpty('id', 'create');
		$validator
			->requirePresence('body', 'create')
			->notEmpty('body');
		$validator
			->integer('user_id')
			->requirePresence('user_id')
			->notEmpty('user_id');
		$validator
			->requirePresence('movie_id', 'create')
			->notEmpty('movie_id');
		
		return $validator;
	}
	
	public function buildRules(RulesChecker $rules){
		$rules->add($rules->existsIn(['user_id'], 'Users'));
		return $rules;
	}
}