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
 * @property-read int $title
 * @property-read int $hotelTitle
 * @property-read strung $status
 * @property-read User|null $winner
 */
class Trip extends Model
{
	/** @var User|null  */
	private $_winner = null;

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
	 * @return string
	 */
	public function getTitle()
	{
		return $this->readAttribute('title');
	}

	/**
	 * @return string
	 */
	public function getHotelTitle()
	{
		return $this->readAttribute('hotel_title');
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

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->getDI()->tripManager->getTripStatus($this);
	}

	/**
	 * @return User|null
	 */
	public function getWinner()
	{
		$winnerId = $this->readAttribute('winner_id');
		if (empty($winnerId)) {
			return null;
		}
		if (null === $this->_winner) {
			$this->_winner = User::findFirst($winnerId);
		}
		return $this->_winner;
	}
}