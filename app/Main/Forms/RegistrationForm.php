<?php

namespace App\Main\Forms;

use Phalcon\Filter;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class RegistrationForm extends Form
{
	public function initialize()
	{
		$this->add(
			(new Element\Password("password"))
				->addValidators(
					[
						new Validator\PresenceOf(
							[
								'message' => 'Поле не может быть пустым'
							]
						),
						new Validator\StringLength(
							[
								'min'            => 6,
								'max'            => 40,
								'messageMinimum' => 'Минимальная длина пароля 6 символов',
								'messageMaximum' => 'Минимальная длина пароля 6 символов'
							]
						),
						new Validator\Regex(
							[
								'pattern' => '/.*\d.*/',
								'message' => 'Поле должно содержать минимум 1 цифру'
							]
						),
						new Validator\Regex(
							[
								'pattern' => '/^[@_\.\,\-1234567890qwertyuiopasdfghjklzxcvbnm]+$/i',
								'message' => 'Можно использовать только буквы латинского алфавита (a–z), цифры и знаки пунктуации'
							]
						)
					]
				)
		);
		$this->add(
			(new Element\Text("email"))
				->addFilter(Filter::FILTER_TRIM)
				->addValidators(
					[
						new Validator\PresenceOf(
							[
								'message' => 'Поле не может быть пустым'
							]
						),

					]
				)
		);
	}
}