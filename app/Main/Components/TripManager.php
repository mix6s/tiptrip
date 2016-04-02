<?php

namespace App\Main\Components;

use App\Main\Forms\TripFilterForm;
use App\Main\Models\Direction;
use App\Main\Models\Location;
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

	const DEFAULT_LIMIT = 20;

	/** @var Direction[]|null */
	private $_directions = null;

	/**
	 * @param TripFilterForm $filter
	 * @return \Phalcon\Mvc\Model\ResultsetInterface
	 */
	public function getTripsByFilterForm(TripFilterForm $filter)
	{
		$page = (int)$filter->getValue('page');
		return $this->getTrips([
			'status' => $filter->getValue('status'),
			'direction' => $filter->getValue('direction'),
			'onlyFav' => $filter->getValue('onlyFav'),
			'priceTo' => $filter->getValue('priceTo'),
			'priceFrom' => $filter->getValue('priceFrom'),
			'offset' => (int)$filter->getValue('page') * self::DEFAULT_LIMIT,
		]);
	}

	public function getLocationForNewAttempt()
	{
		/** @var Location $location */
		$location = Location::findFirst(['deleted = 0']);
		if (empty($location)) {

		}
		$location->delete();
		return $location;
	}

	/**
	 * @param array $filter
	 * @return \Phalcon\Mvc\Model\ResultsetInterface
	 */
	private function getTrips(array $filter)
	{
		$query = Trip::query()->where("active = :status:", ["status" => "1"]);
		if (!empty($filter['direction'])) {
			$query->andWhere("direction_id = :direction:", ["direction" => $filter['direction']]);
		}

		switch (!empty($filter['status']) ? $filter['status'] : null) {
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
				break;
		}

		if (!empty($filter['priceFrom'])) {
			$query->andWhere("price >= :priceFrom:", ["priceFrom" => (float)$filter['priceFrom']]);
		}

		if (!empty($filter['priceTo'])) {
			$query->andWhere("price <= :priceTo:", ["priceTo" => (float)$filter['priceTo']]);
		}

		if (!empty($filter['onlyFav'])) {
		}

		return $query->limit(
			!empty($filter['limit']) ? (int)$filter['limit'] : self::DEFAULT_LIMIT,
			!empty($filter['offset']) ? (int)$filter['offset'] : 0
		)->execute();
	}

	/**
	 * @return \App\Main\Models\Direction[]
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