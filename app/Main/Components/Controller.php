<?php

namespace App\Main\Components;

use Phalcon\Mvc\Controller as PhalconController;
use Phalcon\Mvc\Dispatcher;

class Controller extends PhalconController
{
	public function beforeExecuteRoute(Dispatcher $dispatcher)
	{
		if (!$this->getDI()->securityManager->checkPermissions(
			$dispatcher->getControllerName(),
			$dispatcher->getActionName()
		)
		) {
			$this->flash->notice('You don\'t have access to this module');
			$dispatcher->forward(
				[
					'controller' => 'index',
					'action' => 'index'
				]
			);
			return false;
		}
	}

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