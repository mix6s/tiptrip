<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;
use Phalcon\Mvc\View;

class AttemptController extends Controller
{
	public function indexAction($id)
	{
		$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
		$user = $this->getDI()->securityManager->getCurrentUser();
		$this->view->setVars([
			'trip' => $this->getDI()->tripManager->getTrip($id),
			'attempt' => $this->getDI()->tripManager->getUserActiveAttempt($user->id, $id)
		]);
	}

	public function buyExtraTimeAction($id)
	{
		$this->setJsonResponse();
		$user = $this->getDI()->securityManager->getCurrentUser();
		if (empty($user)) {
			return ['status' => false, 'message' => ''];
		}
		$trip = $this->getDI()->tripManager->getTrip($id);
		if (empty($trip)) {
			return ['status' => false, 'message' => ''];
		}
		$attempt = $this->getDI()->tripManager->buyExtraTimeForAttempt($user, $trip);
		return ['status' => true, 'attempt' => $attempt->toArray()];
	}

	public function makeGuessAction($id)
	{
		$this->setJsonResponse();
		$user = $this->getDI()->securityManager->getCurrentUser();
		if (empty($user)) {
			return ['status' => false, 'message' => ''];
		}
		$trip = $this->getDI()->tripManager->getTrip($id);
		if (empty($trip)) {
			return ['status' => false, 'message' => ''];
		}
		$location = $this->request->getPost('location', null, []);
		$attempt = $this->getDI()->tripManager->makeGuess($user, $trip, $location);
		return ['status' => true, 'attempt' => $attempt];
	}

	public function newAction($id)
	{
		$this->setJsonResponse();
		$user = $this->getDI()->securityManager->getCurrentUser();
		if (empty($user)) {
			return ['status' => false, 'message' => ''];
		}
		$trip = $this->getDI()->tripManager->getTrip($id);
		if (empty($trip)) {
			return ['status' => false, 'message' => ''];
		}
		$attempt = $this->getDI()->tripManager->getUserActiveAttempt($user->id, $id);
		if (!empty($attempt)) {
			return ['status' => false, 'message' => ''];
		}
		$attempt = $this->getDI()->tripManager->createNewAttempt($user, $trip);
		return ['status' => true, 'attempt' => $attempt->toArray()];
	}
}