<?php

namespace App\Main\Components;

use Phalcon\Mvc\Model as PhalconModel;

class Model extends PhalconModel
{
	/**
	 * @return DI
	 */
	public function getDI()
	{
		return parent::getDI();
	}
}