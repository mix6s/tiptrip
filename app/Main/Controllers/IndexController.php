<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;

class IndexController extends Controller
{
	public function indexAction()
	{
		
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