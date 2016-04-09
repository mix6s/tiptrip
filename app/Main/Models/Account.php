<?php

namespace App\Main\Models;

use App\Main\Components\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator;

/**
 * Class Account
 * @package App\Main\Models
 * @property-read int $id
 * @property-read int $uid
 * @property float $amount
 */
class Account extends Model
{
	private $id;
	private $uid;
	private $amount;

	public function beforeCreate()
	{

	}

	public function initialize()
	{
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
	public function getUid()
	{
		return $this->readAttribute('uid');
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
	public function getAmount()
	{
		return $this->readAttribute('amount');
	}

	/**
	 * @param float $value
	 */
	public function setAmount($value)
	{
		$this->writeAttribute('amount', $value);
	}
}