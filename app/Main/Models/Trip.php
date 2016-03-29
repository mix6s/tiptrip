<?php

namespace App\Main\Models;

use App\Main\Components\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator;

/**
 * Class Trip
 * @package App\Main\Models
 * @property-read int $id
 * @property-read \DateTime $startDt
 * @property-read \DateTime $endDt
 * @property-read Direction $direction
 * @property-read float $ticketPrice
 * @property-read float $price
 * @property-read int $multiplicity
 */
class Trip extends Model
{
	public function beforeCreate()
	{

	}

	public function initialize()
	{
		$this->addBehavior(
			new Timestampable(
				[
					'beforeValidationOnCreate' => [
						'field' => 'created_at',
						'format' => 'Y-m-d H:i:s'
					],
				]
			)
		);
		$this->addBehavior(
			new Timestampable(
				[
					'beforeValidationOnCreate' => [
						'field' => 'updated_at',
						'format' => 'Y-m-d H:i:s'
					],
					'beforeValidationOnUpdate' => [
						'field' => 'updated_at',
						'format' => 'Y-m-d H:i:s'
					]
				]
			)
		);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->readAttribute('id');
	}

	/**
	 * @return \DateTime
	 */
	public function getStartDt()
	{
		return new \DateTime($this->readAttribute('start_dt'));
	}

	/**
	 * @return \DateTime
	 */
	public function getEndDt()
	{
		return new \DateTime($this->readAttribute('end_dt'));
	}

	/**
	 * @return Direction
	 */
	public function getDirection()
	{
		return $this->getDI()->tripManager->getDirection($this->readAttribute('direction_id'));
	}

	/**
	 * @return float
	 */
	public function getPrice()
	{
		return $this->readAttribute('price');
	}

	/**
	 * @return int
	 */
	public function getMultiplicity()
	{
		return $this->readAttribute('multiplicity');
	}

	/**
	 * @return float
	 */
	public function getTicketPrice()
	{
		return ceil($this->getPrice() / $this->getMultiplicity());
	}
}