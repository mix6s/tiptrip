<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;
use Phalcon\Mvc\View;

class AttemptController extends Controller
{
	public function indexAction()
	{
		$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
		$this->getDI()->popupManager->addPopupToOutput('attempt_result');
		$this->view->setVars([
			'location' => $this->getDI()->tripManager->getLocationForNewAttempt()
		]);
	}
}