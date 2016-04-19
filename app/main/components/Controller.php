<?php

namespace App\Main\Components;

use Phalcon\Mvc\Controller as PhalconController;
use Phalcon\Mvc\Dispatcher;

class Controller extends PhalconController
{
	private $_isJsonResponse = false;

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

	public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
	{
		if ($this->_isJsonResponse) {
			$data = $dispatcher->getReturnedValue();
			if (is_array($data)) {
				$data = json_encode($data);
			}

			$this->response->setContent($data);
			return $this->response->send();
		}
	}

	/**
	 * @param $data
	 */
	public function setJsonResponse()
	{
		$this->view->disable();
		$this->_isJsonResponse = true;
		$this->response->setContentType('application/json', 'UTF-8');
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