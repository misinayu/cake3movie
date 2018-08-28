<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class MoviesTable extends Table{
	public function initialize(array $config){
		parent::initialize($config);
		
		$this->table('movies');
		$this->displayField('id');
		$this->primaryKey('id');
		
		$this->addBehavior('Timestamp');
		
		$this->belongsTo('Playlists', [
				'foreignKey' => 'playlist_id',
				'joinType' => 'INNER'
		]);
	}
	
	public function validationDefault(Validator $validator){
		$validator
			->integer('id')
			->allowEmpty('id', 'create');
		$validator
			->requirePresence('video_id', 'create')
			->notEmpty('video_id');
		$validator
			->integer('order_num')
			->requirePresence('order_num')
			->notEmpty('order_num');
		$validator
			->integer('playlist_id')
			->requirePresence('playlist_id', 'create')
			->notEmpty('playlist_id');
		
		return $validator;
	}
	
	public function buildRules(RulesChecker $rules){
		$rules->add($rules->existsIn(['playlist_id'], 'Playlists'));
		return $rules;
	}
}