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

	public function listAction()
	{
		$form = new TripFilterForm();
		$form->bind($this->request->get());
		$trips = $this->getDI()->tripManager->getTrips($form);
		$this->view->setVars(
			[
				'trips' => $trips,
				'form' => $form
			]
		);
	}
}