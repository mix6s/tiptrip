<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;
use App\Main\Components\TripManager;
use App\Main\Forms\TripFilterForm;
use App\Main\Models\Trip;

class IndexController extends Controller
{
	public function indexAction()
	{
		$form = new TripFilterForm();
		$form->assign(['status' => TripManager::STATUS_ACTIVE]);
		$trips = $this->getDI()->tripManager->getTripsByFilterForm($form);
		$this->view->setVars(
			[
				'trips' => $trips,
			]
		);
	}

	public function clearCacheAction()
	{
		if ($this->getDI()->config->env == 'dev') {
			$this->getDI()->modelsMetadata->reset();
			$this->getDI()->cache->flush();
		}
		$this->dispatcher->forward(
			[
				'controller' => 'index',
				'action' => 'index'
			]
		);
		return false;
	}
}