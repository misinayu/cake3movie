<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Playlist extends Entity{
	protected $_accessible = [
			'*' => true,
			'id' => false
	];
}