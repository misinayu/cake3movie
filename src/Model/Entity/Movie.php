<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Movie extends Entity{
	protected $_accessible = [
			'*' => true,
			'id' => false
	];
}