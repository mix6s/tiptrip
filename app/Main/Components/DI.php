<?php

namespace App\Main\Components;

use Phalcon\Di\FactoryDefault;

/**
 * App\Main\Components\DI
 *
 * @property \Phalcon\Logger\AdapterInterface $logger;
 */
class DI extends FactoryDefault
{
	public function __get($propertyName)
	{
		return $this->get($propertyName);
	}
}