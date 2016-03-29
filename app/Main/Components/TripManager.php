<?php

namespace App\Main\Components;

use App\Main\Forms\TripFilterForm;
use App\Main\Models\Direction;
use App\Main\Models\Trip;
use Phalcon\Mvc\User\Component;
use Phalcon\Validation\Message;

/**
 * Class TripManager
 * @package App\Main\Components
 */
class TripManager extends Component
{
	const STATUS_SOON = 'soon';
	const STATUS_ACTIVE = 'active';
	const STATUS_ENDED = 'ended';

	const CACHE_DIRECTIONS = 'directions';

	/** @var Direction[]|null */
	private $_directions = null;

	public function getTrips(TripFilterForm $filter)
	{
		$query = Trip::query()->where("active = :status:", ["status" => "1"]);
		$direction = $filter->getValue('direction');
		if (!empty($direction)) {
			$query->andWhere("direction_id = :direction:", ["direction" => $direction]);
		}

		$status = $filter->getValue('status');
		switch ($status) {
			case self::STATUS_SOON:
				$query->andWhere("start_dt > NOW()");
				break;
			case self::STATUS_ACTIVE:
				$query->andWhere("start_dt <= NOW() AND end_dt > NOW()");
				break;
			case self::STATUS_ENDED:
				$query->andWhere("end_dt <= NOW()");
				break;
			default:
				$query->andWhere("end_dt > NOW()");
				break;
		}

		$priceFrom = $filter->getValue('priceFrom');
		if (!empty($priceFrom)) {
			$query->andWhere("price >= :priceFrom:", ["priceFrom" => (float)$priceFrom]);
		}

		$priceTo = $filter->getValue('priceTo');
		if (!empty($priceTo)) {
			$query->andWhere("price <= :priceTo:", ["priceTo" => (float)$priceTo]);
		}

		$onlyFav = $filter->getValue('onlyFav');
		if ($onlyFav) {
		}
		return $query->execute();
	}

	/**
	 * @return \Phalcon\Mvc\Model\Resultset\Simple
	 */
	public function getDirections()
	{
		if (null === $this->_directions) {
			$this->_directions = $this->getDI()->cache->get(self::CACHE_DIRECTIONS);
			if (empty($this->_directions)) {
				$this->_directions = Direction::find(['active = 1']);
				$this->getDI()->cache->save(self::CACHE_DIRECTIONS, $this->_directions, 86400);
			}
		}
		return $this->_directions;
	}

	/**
	 * @param $id
	 * @return Direction
	 */
	public function getDirection($id)
	{
		/** @var Direction $direction */
		foreach ($this->getDirections() as $direction) {
			if ($direction->id == $id) {
				return $direction;
			}
		}
		return (new Direction())->assign(['title' => 'неопределенно', 'active' => 1]);
	}

	/**
	 * @return array
	 */
	public function getStatuses()
	{
		return [
			self::STATUS_SOON => 'скоро',
			self::STATUS_ACTIVE => 'активен',
			self::STATUS_ENDED => 'завершен',
		];
	}

	/**
	 * @return DI
	 */
	public function getDI()
	{
		return parent::getDI();
	}
}