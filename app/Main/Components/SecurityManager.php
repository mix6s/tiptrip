<?php

namespace App\Main\Components;

use App\Main\Forms\RegistrationForm;
use App\Main\Models\Users;
use Phalcon\Validation\Message;

/**
 * Class SecurityManager
 * @package App\Main\Components
 */
class SecurityManager
{
	/**
	 * @param RegistrationForm $form
	 * @param array $data
	 * @return Users|null|\Phalcon\Mvc\MessageInterface[]
	 */
	public function registerNewUser(RegistrationForm $form, array $data)
	{
		$user = new Users();
		$form->bind($data, $user);
		if (!$form->isValid()) {
			return null;
		}
		if (!$user->save()) {
			return $user->getMessages();
		}
		return $user;
	}
}