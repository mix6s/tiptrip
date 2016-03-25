<?php

namespace App\Main\Components;

use App\Main\Forms\LoginForm;
use App\Main\Forms\RegistrationForm;
use App\Main\Models\Users;
use Phalcon\Mvc\Model\MessageInterface;
use Phalcon\Mvc\User\Component;
use Phalcon\Validation\Message;

/**
 * Class SecurityManager
 * @package App\Main\Components
 */
class SecurityManager extends Component
{
	const SESSION_AUTH = 'auth-identity';

	/** @var null|Users  */
	private $_currentUser;

	/**
	 * @param RegistrationForm $form
	 * @param array $data
	 * @return Users|null
	 */
	public function register(RegistrationForm $form, array $data)
	{
		$user = new Users();
		$form->bind($data, $user);
		if (!$form->isValid()) {
			return null;
		}
		if (!$user->save()) {
			/** @var MessageInterface $message */
			foreach ($user->getMessages() as $message) {
				$form->appendMessageFor($message->getField(), $message);
			}
			return null;
		}
		return $user;
	}

	public function authentificate(LoginForm $form, array $data)
	{
		$credentials = new \ArrayObject(
			[
				'email' => '',
				'password' => ''
			], \ArrayObject::ARRAY_AS_PROPS
		);

		$form->bind($data, $credentials);
		if (!$form->isValid()) {
			return null;
		}
		$user = Users::findFirstByEmail($credentials->email);
		if (!$user) {
			$this->getDI()->security->hash(rand());
			$form->appendMessageFor('password', new Message('Неправильная почта или пароль', 'password'));
			return null;
		}

		if (!$this->getDI()->security->checkHash($credentials->password, $user->password)) {
			$form->appendMessageFor('password', new Message('Неправильная почта или пароль', 'password'));
			return null;
		}
		return $user;
	}


	public function authorizeUser(Users $user)
	{
		$this->getDI()->session->set(self::SESSION_AUTH, ['id' => $user->getId()]);
	}

	public function unauthorizeCurrentUser()
	{
		$this->_currentUser == null;
		$this->getDI()->session->remove(self::SESSION_AUTH);
	}

	/**
	 * @return Users|null
	 */
	public function getCurrentUser()
	{
		if ($this->_currentUser === null) {
			$identity = $this->session->get(self::SESSION_AUTH);
			if (empty($identity['id'])) {
				return null;
			}
			$user = Users::findFirstById($identity['id']);
			if (empty($user)) {
				return null;
			}
			$this->_currentUser = $user;
		}
		return $this->_currentUser;
	}

	public function isCurrentUserLoggin()
	{
		return $this->getCurrentUser() !== null;
	}

	/**
	 * @return DI
	 */
	public function getDI()
	{
		return parent::getDI();
	}

	public function checkPermissions($controller, $action)
	{
		if (!$this->getDI()->acl->isPrivate($controller, $action)) {
			return true;
		}

		$currentUserRole = $this->getCurrentUser() === null ? Acl::ROLE_GUEST : Acl::ROLE_USER;
		return $this->getDI()->acl->isAllowed($currentUserRole, $controller, $action);
	}
}