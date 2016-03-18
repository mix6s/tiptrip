<?php

namespace App\Main\Components;

use Phalcon\Mvc\Controller as PhalconController;

class Controller extends PhalconController
{
	/**
	 * @return DI
	 */
	public function getDI()
	{
		return parent::getDI();
	}
}