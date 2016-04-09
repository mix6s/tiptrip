<?php

namespace App\Main\Components;

use App\Main\Components\PopupManager;
use App\Main\Helpers\BootstrapTag;
use Phalcon\Di\FactoryDefault;

/**
 * App\Main\Components\DI
 *
 * @property \Phalcon\Logger\AdapterInterface $logger;
 * @property SecurityManager $securityManager
 * @property PopupManager $popupManager
 * @property \Phalcon\Forms\Manager $forms
 * @property \Phalcon\Mvc\Model\Metadata\Memcache $modelsMetadata
 * @property TripManager $tripManager
 * @property BootstrapTag $tag
 * @property Acl $acl
 * @property \Phalcon\Mvc\Url $url
 * @property \Phalcon\Mvc\View $view
 * @property \Phalcon\Cache\Backend\Memcache $cache
 * @property \Phalcon\Security $security
 * @property \Phalcon\Session\Adapter\Files|\Phalcon\Session\Adapter|\Phalcon\Session\AdapterInterface $session
 */
class DI extends FactoryDefault
{
	public function __get($propertyName)
	{
		return $this->get($propertyName);
	}
}