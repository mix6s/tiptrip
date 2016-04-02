<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;

class AttemptController extends Controller
{
	public function indexAction()
	{
		$this->view->setVars([
			'location' => $this->getDI()->tripManager->getLocationForNewAttempt()
		]);
	}
}