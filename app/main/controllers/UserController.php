<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;
use App\Main\Components\TripManager;
use App\Main\Forms\LoginForm;
use App\Main\Forms\PasswordRestoreForm;
use App\Main\Forms\RegistrationForm;
use App\Main\Models\Attempt;
use App\Main\Models\Trip;
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

	public function passwordRestoreAction()
	{
		$form = new PasswordRestoreForm();
		if ($this->request->isPost()) {
			$password = $this->getDI()->securityManager->restorePassword($form, $this->request->getPost());
			if ($password) {
				$this->flash->success('Новый пароль ' . $password);
			} else {
				$this->flash->warning('Ошибка востановления пароля');
			}
		}
		$this->view->setVars(
			[
				'form' => $form,
			]
		);
	}

	public function profileAction()
	{
		$user = $this->getDI()->securityManager->getCurrentUser();
		$userAttempts = $this->getDI()->tripManager->getUserAttempts($user);
		$winTrips = $this->getDI()->tripManager->getUserWinTrips($user);
		$tripsAttempts = [];
		$tripsAttemptsClosed = [];
		foreach ($userAttempts as $data) {
			/** @var Trip $trip */
			$trip = $data->trip;
			if ($trip->status == TripManager::STATUS_ACTIVE) {
				if (empty($tripsAttempts[$trip->id])) {
					$tripsAttempts[$trip->id] = ['trip' => $trip, 'attempts' => []];
				}
				$tripsAttempts[$trip->id]['attempts'][] = $data->attempt;
			} else {
				if (empty($tripsAttemptsClosed[$trip->id])) {
					$tripsAttemptsClosed[$trip->id] = ['trip' => $trip, 'attempts' => []];
				}
				$tripsAttemptsClosed[$trip->id]['attempts'][] = $data->attempt;
			}
		}

		$this->view->setVars(
			[
				'tripsAttempts' => $tripsAttempts,
				'tripsAttemptsClosed' => $tripsAttemptsClosed,
				'winTrips' => $winTrips
			]
		);
	}
}