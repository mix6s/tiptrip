<?php

namespace App\Main\Components;

use Phalcon\Mvc\Controller as PhalconController;

class Controller extends PhalconController
{
	public function initialize()
	{
		$this->view->setTemplateBefore('main');
	}

	/**
	 * @return DI
	 */
	public function getDI()
	{
		return parent::getDI();
	}
}