<?php

namespace App\Main\Forms;

use Phalcon\Filter;
use App\Main\Components\Form;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class PasswordRestoreForm extends Form
{
	public function initialize()
	{
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
						new Validator\Regex(
							[
								'pattern' => '/^([a-z0-9_\.-]+\@[\da-z\.-]+\.[a-z\.]{2,6})|(\+[7]{1}[0-9]{10})$/',
								'message' => 'Поле заполнено некорректно'
							]
						)
					]
				)
		);
	}
}