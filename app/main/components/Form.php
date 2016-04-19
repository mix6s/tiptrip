<?php

namespace App\Main\Components;

use Phalcon\Forms\Form AS PhalconForm;
use Phalcon\Mvc\Model;

class Form extends PhalconForm
{
	/**
	 * @param mixed $attribute
	 * @param string $message
	 */
	public function appendMessageFor($attribute, $message)
	{
		$this->_messages[$attribute][] = $message;
	}

	/**
	 * @return DI
	 */
	public function getDI()
	{
		return parent::getDI();
	}

	/**
	 * @param array $data
	 * @param null $entity
	 * @param null $whitelist
	 * @return PhalconForm
	 */
	public function assign($data, $entity = null, $whitelist = null)
	{
		if (null === $this->_entity && null === $entity) {
			$entityAttributes = [];
			foreach ($this->getElements() as $element) {
				$entityAttributes[$element->getName()] = null;
			}
			$entity = $this->_entity = new \ArrayObject(
				$entityAttributes, \ArrayObject::ARRAY_AS_PROPS
			);
		}
		return parent::bind($data, $entity, $whitelist);
	}
}