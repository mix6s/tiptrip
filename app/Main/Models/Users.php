<?php

namespace App\Main\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator;

class Users extends Model
{
	protected $id;
	protected $email;
	protected $updated_at;
	protected $created_at;

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
			new Validator\Regex(
				[
					"field" => "email",
					'pattern' => '/^([a-z0-9_\.-]+\@[\da-z\.-]+\.[a-z\.]{2,6})|(\+[7]{1}[0-9]{10})$/',
					'message' => 'Поле заполнено некорректно'
				]
			)
		);

		return $this->validationHasFailed() != true;
	}

	public function setLogin($login)
	{
		$this->email = $login;
	}
}