<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;
use App\Main\Forms\TripFilterForm;
use App\Main\Models\Trip;

class TripController extends Controller
{
	public function indexAction($id)
	{

	}

	public function rollAction($id)
	{
		$this->setJsonResponse();
		$trip = $this->getDI()->tripManager->getTrip($id);
		if (empty($trip)) {
			return null;
		}
		return $this->getDI()->tripManager->playTrip($trip)->toArray();

	}

	public function listAction()
	{
		$form = new TripFilterForm();
		$form->assign($this->request->get());
		$trips = $this->getDI()->tripManager->getTripsByFilterForm($form);
		$this->view->setVars(
			[
				'trips' => $trips,
				'form' => $form
			]
		);
	}
}