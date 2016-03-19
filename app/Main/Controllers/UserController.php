<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;
use App\Main\Forms\RegistrationForm;

class UserController extends Controller
{
	public function loginAction()
	{

	}

	public function registrationAction()
	{

		$form = new RegistrationForm();

		if ($this->request->isPost()) {
			$user = $this->getDI()->securityManager->registerNewUser($form, $this->request->getPost());
			var_dump($user);
		}

		$this->view->setVars(
			[
				'form' => $form,
			]
		);
	}
}