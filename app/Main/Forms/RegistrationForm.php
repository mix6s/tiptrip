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
		$this->add((new Element\Password("password")));
		$this->add((new Element\Text("email"))->addFilter(Filter::FILTER_TRIM));
	}

	public function appendMessageFor($attribute, $message)
	{
		$this->_messages[$attribute][] = $message;
	}
}