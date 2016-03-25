<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;
use App\Main\Forms\LoginForm;
use App\Main\Forms\RegistrationForm;
use Phalcon\Validation\Exception;

class UserController extends Controller
{
	public function loginAction()
	{
		$form = new LoginForm();
		if ($this->request->isPost()) {
			$user = $this->getDI()->securityManager->authentificate($form, $this->request->getPost());
			if ($user) {
				$this->getDI()->securityManager->authorizeUser($user);
				$this->flash->success('Авторизация прошла успешно');
				return $this->response->redirect('/');
			}
		}
		$this->view->setVars(
			[
				'form' => $form,
			]
		);
	}

	public function registrationAction()
	{
		$form = new RegistrationForm();
		if ($this->request->isPost()) {
			$user = $this->getDI()->securityManager->register($form, $this->request->getPost());
			if ($user) {
				$this->getDI()->securityManager->authorizeUser($user);
				$this->flash->success('Регистрация прошла успешно');
				return $this->response->redirect('/');
			}
		}
		$this->view->setVars(
			[
				'form' => $form,
			]
		);
	}

	public function logoutAction()
	{
		$this->getDI()->securityManager->unauthorizeCurrentUser();
		return $this->response->redirect('/');
	}

	public function profileAction()
	{

	}
}