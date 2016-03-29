<?php

namespace App\Main\Components;

use App\Main\Helpers\BootstrapTag;
use Phalcon\Di\FactoryDefault;

/**
 * App\Main\Components\DI
 *
 * @property \Phalcon\Logger\AdapterInterface $logger;
 * @property SecurityManager $securityManager
 * @property TripManager $tripManager
 * @property BootstrapTag $tag
 * @property Acl $acl
 * @property \Phalcon\Cache\BackendInterface $cache
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