<?php

namespace App\Main\Models;

use App\Main\Components\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator;

/**
 * Class Users
 * @package App\Main\Models
 * @property string $nickname
 * @property-read int $id
 * @property string $password
 * @property-read Account $account
 */
class Users extends Model
{
	private $id;
	private $email;
	private $password;
	private $nickname;
	private $updated_at;
	private $created_at;

	private $_account;

	public function beforeCreate()
	{
		$this->password = $this->getDI()->security->hash($this->password);
		$this->nickname = $this->getRandomNickname();
	}

	public function afterCreate()
	{
		$this->createUserAccount();
	}

	/**
	 * @return Account
	 */
	private function createUserAccount()
	{
		$userAcount = new Account();
		$userAcount->save(['amount' => 0, 'uid' => $this->getId()]);
		return $userAcount;
	}

	public function getRandomNickname()
	{
		$nicknames = [
			'Веселый турист',
			'Мертвый турист',
		];
		return $nicknames[rand(0, count($nicknames) - 1)];
	}

	public function initialize()
	{
		$this->addBehavior(
			new Timestampable(
				[
					'beforeValidationOnCreate' => [
						'field' => 'created_at',
						'format' => 'Y-m-d H:i:s'
					]
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

	public function validation()
	{
		$this->validate(
			new Validator\Uniqueness(
				[
					"field" => "email",
					"message" => "Данный контакт уже используется"
				]
			)
		);

		$this->validate(
			new Validator\PresenceOf(
				[
					"field" => "email",
					"message" => "Поле не может быть пустым"
				]
			)
		);

		$this->validate(
			new Validator\Regex(
				[
					"field" => "email",
					'pattern' => '/^([a-z0-9_\.-]+\@[\da-z\.-]+\.[a-z\.]{2,6})|(\+[7]{1}[0-9]{10})$/',
					'message' => 'Поле заполнено некорректно'
				]
			)
		);

		$this->validate(
			new Validator\PresenceOf(
				[
					"field" => "password",
					"message" => "Поле не может быть пустым"
				]
			)
		);

		$this->validate(
			new Validator\StringLength(
				[
					'field' => 'password',
					'min'            => 6,
					'max'            => 40,
					'messageMinimum' => 'Минимальная длина пароля 6 символов',
					'messageMaximum' => 'Минимальная длина пароля 6 символов'
				]
			)
		);

		$this->validate(
			new Validator\Regex(
				[
					'field' => 'password',
					'pattern' => '/.*\d.*/',
					'message' => 'Поле должно содержать минимум 1 цифру'
				]
			)
		);

		$this->validate(
			new Validator\Regex(
				[
					'field' => 'password',
					'pattern' => '/^[@_\.\,\-1234567890qwertyuiopasdfghjklzxcvbnm]+$/i',
					'message' => 'Можно использовать только буквы латинского алфавита (a–z), цифры и знаки пунктуации'
				]
			)
		);

		return $this->validationHasFailed() != true;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return string
	 */
	public function setPassword($value)
	{
		$this->password = $value;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getNickname()
	{
		return $this->nickname;
	}

	/**
	 * @param string $value
	 */
	public function setNickname($value)
	{
		$this->nickname = $value;
	}

	/**
	 * @return Account
	 */
	public function getAccount()
	{
		if (null === $this->account) {
			$this->account = Account::findByUid($this->id);
			if (!$this->account) {
				$this->account = $this->createUserAccount();
			}
		}
		return $this->account;
	}
}