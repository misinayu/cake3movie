<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PlaylistMoviesTable extends Table{
	public function initialize(array $config){
		parent::initialize($config);
		
		$this->table('playlist_movies');
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
			->requirePresence('movie_id', 'create')
			->notEmpty('movie_id');
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