<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class PlaylistMovie extends Entity{
	protected $_accessible = [
			'*' => true,
			'id' => false
	];
}