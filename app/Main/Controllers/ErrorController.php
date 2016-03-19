<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;

class ErrorController extends Controller
{
	public function notFoundAction()
	{

	}

	public function uncaughtExceptionAction()
	{
		$this->response->setStatusCode(500, 'Internal Server Error');
	}
}