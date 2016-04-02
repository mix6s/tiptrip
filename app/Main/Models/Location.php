<?php

namespace App\Main\Models;

use App\Main\Components\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

/**
 * Class Location
 * @package App\Main\Models
 * @property-read int $id
 * @property-read int $deleted
 * @property-read float $latitude
 * @property-read float $longitude
 */
class Location extends Model
{
	public function initialize()
	{
		$this->addBehavior(new SoftDelete([
			'field' => 'deleted',
			'value' => '1'
		]));
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->readAttribute('id');
	}

	/**
	 * @return float
	 */
	public function getLatitude()
	{
		return $this->readAttribute('latitude');
	}

	/**
	 * @return float
	 */
	public function getLongitude()
	{
		return $this->readAttribute('longitude');
	}

	/**
	 * @return int
	 */
	public function getDeleted()
	{
		return $this->readAttribute('deleted');
	}
}