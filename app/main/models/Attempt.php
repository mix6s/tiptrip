<?php

namespace App\Main\Models;

use App\Main\Components\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

/**
 * Class Attempt
 * @package App\Main\Models
 * @property-read int $id
 * @property-read User $user
 * @property-read Trip $trip
 * @property-read array $sourceLocation
 * @property-read array $userLocation
 * @property-read float|null $distance
 * @property-read int $count
 * @property-read \DateTime $expiredAt
 * @property-read \DateTime $createdAt
 * @property-read int $secondsToExpire
 */
class Attempt extends Model
{
	const STATUS_ACTIVE = 0;

	private $_user = null;
	private $_trip = null;

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
	 * @return null|User
	 */
	public function getUser()
	{
		if (null === $this->_user) {
			$this->_user = User::findFirst($this->readAttribute('user_id'));
		}
		return $this->_user;
	}

	/**
	 * @return null|Trip
	 */
	public function getTrip()
	{
		if (null === $this->_trip) {
			$this->_trip = Trip::findFirst($this->readAttribute('trip_id'));
		}
		return $this->_trip;
	}

	/**
	 * @return array
	 */
	public function getSourceLocation()
	{
		return ['lat' => $this->readAttribute('source_latitude'), 'lng' => $this->readAttribute('source_longitude')];
	}

	/**
	 * @return array
	 */
	public function getUserLocation()
	{
		return ['lat' => $this->readAttribute('user_latitude'), 'lng' => $this->readAttribute('user_longitude')];
	}

	/**
	 * @param $lat
	 * @param $lng
	 */
	public function setSourceLocation($lat, $lng)
	{
		$this->writeAttribute('source_latitude', $lat);
		$this->writeAttribute('source_longitude', $lng);
	}

	/**
	 * @param $lat
	 * @param $lng
	 */
	public function setUserLocation($lat, $lng)
	{
		$this->writeAttribute('user_latitude', $lat);
		$this->writeAttribute('user_longitude', $lng);
	}

	/**
	 * @return float|null
	 */
	public function getDistance()
	{
		return $this->readAttribute('distance');
	}

	/**
	 * @return int
	 */
	public function getCount()
	{
		return $this->readAttribute('count');
	}

	/**
	 * @return \DateTime
	 */
	public function getExpiredAt()
	{
		return new \DateTime($this->readAttribute('expired_at'));
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return new \DateTime($this->readAttribute('created_at'));
	}

	/**
	 * @return int
	 */
	public function getSecondsToExpire()
	{
		return $this->expiredAt->getTimestamp() - time();
	}

	/**
	 * @param null $columns
	 * @return array
	 */
	public function toArray($columns = null)
	{
		$array = parent::toArray($columns);
		$array['seconds_to_expire'] = $this->secondsToExpire;
		return $array;
	}
}