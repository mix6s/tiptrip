<?php

namespace App\Main\Forms;

use Phalcon\Filter;
use App\Main\Components\Form;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class LoginForm extends Form
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