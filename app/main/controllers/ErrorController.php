<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;

class ErrorController extends Controller
{
	public function notFoundAction()
	{
		$this->response->setStatusCode(404, 'Not Found');
	}

	public function uncaughtExceptionAction(\Exception $exception)
	{
		if ($this->getDI()->config->env !== 'prod') {
			$this->view->pick('Error\uncaughtExceptionDetails');
			$this->view->setVars(['exception' => $exception]);
		}

		$this->response->setStatusCode(500, 'Internal Server Error');
	}
}