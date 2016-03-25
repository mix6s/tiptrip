<?php

namespace App\Main\Components;

use Phalcon\Mvc\User\Component;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Acl\Resource as AclResource;

class Acl extends Component
{
	const ROLE_GUEST = 'guest';
	const ROLE_USER = 'user';

	/**
	 * The ACL Object
	 *
	 * @var \Phalcon\Acl\Adapter\Memory
	 */
	private $_acl;

	/**
	 * Define the resources that are considered "private". These controller => actions require authentication.
	 *
	 * @var array
	 */
	private $_privateResources = [
		'user' => [
			'profile',
			'logout',
		],
	];


	/**
	 * @param string $controller
	 * @param string $action
	 * @return bool
	 */
	public function isPrivate($controller, $action)
	{
		$controller = strtolower($controller);
		$action = strtolower($action);
		if (!isset($this->getPrivateResources()[$controller])) {
			return false;
		}
		if ($this->getPrivateResources()[$controller] === '*') {
			return true;
		}
		return in_array($action, $this->getPrivateResources()[$controller]);
	}

	/**
	 * Checks if the role is allowed to access a resource
	 *
	 * @param string $role
	 * @param string $controller
	 * @param string $action
	 * @return boolean
	 */
	public function isAllowed($role, $controller, $action)
	{
		return $this->getAcl()->isAllowed($role, $controller, $action);
	}

	/**
	 * Returns the ACL list
	 *
	 * @return \Phalcon\Acl\Adapter\Memory
	 */
	public function getAcl()
	{
		if ($this->_acl === null) {
			$this->_acl = new AclMemory();
			$this->_acl->setDefaultAction(\Phalcon\Acl::DENY);
			$roles = [
				'users' => new AclRole(self::ROLE_GUEST),
				'guests' => new AclRole(self::ROLE_USER)
			];
			foreach ($roles as $role) {
				$this->_acl->addRole($role);
			}
			foreach ($this->getPrivateResources() as $resource => $actions) {
				$this->_acl->addResource(new AclResource($resource), $actions);
			}

			foreach ($this->getPrivateResources() as $resource => $actions) {
				foreach ($actions as $action) {
					$this->_acl->allow(self::ROLE_USER, $resource, $action);
				}
			}
		}
		return $this->_acl;
	}


	/**
	 * Returns all the resources and their actions available in the application
	 *
	 * @return array
	 */
	public function getPrivateResources()
	{
		return $this->_privateResources;
	}
}