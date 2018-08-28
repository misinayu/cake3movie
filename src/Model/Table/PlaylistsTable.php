<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PlaylistsTable extends Table{
	public function initialize(array $config){
		parent::initialize($config);
		
		$this->table('playlists');
		$this->displayField('name');
		$this->primaryKey('id');
		
		$this->addBehavior('Timestamp');
		
		$this->belongsTo('Users', [
				'foreignKey' => 'user_id',
				'joinType' => 'INNER'
		]);
		$this->hasMany('Movies', [
				'foreignKey' => 'playlist_id'
		]);
		
	}
	
	public function validationDefault(Validator $validator){
		$validator
			->integer('id')
			->allowEmpty('id', 'create');
		$validator
			->requirePresence('name', 'create')
			->notEmpty('name');
		$validator
			->integer('user_id')
			->requirePresence('user_id', 'create')
			->notEmpty('user_id');
		
		return $validator;
	}
}