<?php

namespace App\Main\Components;

use App\Main\Forms\TripFilterForm;
use App\Main\Models\Attempt;
use App\Main\Models\Direction;
use App\Main\Models\Location;
use App\Main\Models\Trip;
use App\Main\Models\User;
use Phalcon\Db\RawValue;
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
	const STATUS_WINNER_SEARCH = 'winner_search';

	const CACHE_DIRECTIONS = 'directions';

	const DEFAULT_LIMIT = 20;

	/** @var Direction[]|null */
	private $_directions = null;

	public function makeGuess(User $user, Trip $trip, array $location)
	{
		if (empty($location['lat'])) {
			return null;
		}
		if (empty($location['lng'])) {
			return null;
		}
		$attempt = $this->getUserActiveAttempt($user->id, $trip->id);
		if (empty($attempt)) {
			return null;
		}
		$attempt->setUserLocation($location['lat'], $location['lng']);
		$attempt->save([
			'status' => 1,
		]);
		$attempt->refresh();
		return $attempt;
	}

	/**
	 * @param $userId
	 * @param $tripId
	 * @return Attempt
	 */
	public function getUserActiveAttempt($userId, $tripId)
	{
		$attempt = Attempt::query()
			->where(
				"user_id = :user_id: AND trip_id = :trip_id: AND expired_at > NOW() AND status = :status:",
				["user_id" => $userId, 'trip_id' => $tripId, 'status' => Attempt::STATUS_ACTIVE]
			)
			->execute()
			->getFirst();
		return $attempt;
	}

	/**
	 * @param User $user
	 * @param Trip $trip
	 * @return Attempt
	 */
	public function createNewAttempt(User $user, Trip $trip)
	{
		$location = $this->getDI()->tripManager->getLocationForNewAttempt();
		$attempt = new Attempt();
		$attempt->create([
			'user_id' => $user->id,
			'trip_id' => $trip->id,
			'source_latitude' => $location->latitude,
			'source_longitude' => $location->longitude,
			'expired_at' => new RawValue("now() + INTERVAL '5 minutes'")
		]);
		$attempt->refresh();
		//@todo move this logic to AccountManager
		$user->account->save([
			'amount' => $user->account->amount - $trip->ticketPrice
		]);
		return $attempt;
	}

	/**
	 * @param User $user
	 * @param Trip $trip
	 * @return null|Attempt
	 */
	public function buyExtraTimeForAttempt(User $user, Trip $trip)
	{
		$attempt = $this->getUserActiveAttempt($user->id, $trip->id);
		if (empty($attempt)) {
			return null;
		}
		//@todo move this logic to AccountManager
		$user->account->save([
			'amount' => $user->account->amount - 30
		]);
		$attempt->save([
			'expired_at' => new RawValue("expired_at + INTERVAL '1 minutes'")
		]);
		$attempt->refresh();
		return $attempt;
	}


	/**
	 * @param $tripId
	 * @return mixed
	 */
	public function getTripAttemptCount($tripId)
	{
		return Attempt::count("trip_id = {$tripId}");
	}

	/**
	 * @param $id
	 * @return Trip
	 */
	public function getTrip($id)
	{
		return Trip::query()
			->where("active = :status: AND id = :id:", ["status" => "1", 'id' => $id])
			->execute()
			->getFirst();
	}

	/**
	 * @param TripFilterForm $filter
	 * @return \Phalcon\Mvc\Model\ResultsetInterface
	 */
	public function getTripsByFilterForm(TripFilterForm $filter)
	{
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
				$query->andWhere("end_dt <= NOW() AND winner_id IS NOT NULL");
				break;
			case self::STATUS_WINNER_SEARCH:
				$query->andWhere("end_dt <= NOW() AND winner_id ISNULL");
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
			self::STATUS_SOON => 'Скоро',
			self::STATUS_ACTIVE => 'Активен',
			self::STATUS_ENDED => 'Завершен',
		];
	}

	/**
	 * @return DI
	 */
	public function getDI()
	{
		return parent::getDI();
	}

	/**
	 * @param Trip $trip
	 * @return string
	 */
	public function getTripStatus(Trip $trip)
	{
		$now = time();
		if ($trip->startDt->getTimestamp() > $now) {
			return self::STATUS_SOON;
		} elseif ($trip->startDt->getTimestamp() <= $now && $trip->endDt->getTimestamp() > $now) {
			return self::STATUS_ACTIVE;
		} elseif ($trip->endDt->getTimestamp() <= $now && null === $trip->winner) {
			return self::STATUS_WINNER_SEARCH;
		}
		return self::STATUS_ENDED;
	}
}