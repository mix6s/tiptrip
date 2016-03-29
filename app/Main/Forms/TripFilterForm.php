<?php

namespace App\Main\Forms;

use Phalcon\Filter;
use App\Main\Components\Form;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class TripFilterForm extends Form
{
	public function initialize()
	{
		$this->add(
			(new Element\Select("direction", $this->getDI()->tripManager->getDirections(), [
				'using' => ['id', 'title'],
				'useEmpty' => true,
				'emptyText' => 'Выберите значение...'
			]))->addFilter(Filter::FILTER_ABSINT)
		);

		$this->add(
			(new Element\Select("status", $this->getDI()->tripManager->getStatuses(), [
				'useEmpty' => true,
				'emptyText' => 'Выберите значение...'
			]))
		);

		$this->add(
			(new Element\Text("priceFrom"))->addFilter(Filter::FILTER_FLOAT)
		);

		$this->add(
			(new Element\Text("priceTo"))->addFilter(Filter::FILTER_FLOAT)
		);

		$this->add(
			(new Element\Check("onlyFav", ['value' => '1']))
		);
	}
}