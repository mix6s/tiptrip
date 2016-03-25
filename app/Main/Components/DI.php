<?php

namespace App\Main\Components;

use Phalcon\Di\FactoryDefault;

/**
 * App\Main\Components\DI
 *
 * @property \Phalcon\Logger\AdapterInterface $logger;
 * @property SecurityManager $securityManager
 * @property Acl $acl
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