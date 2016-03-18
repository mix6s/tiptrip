<?php

namespace App\Main\Controllers;

use App\Main\Components\Controller;

class SessionController extends Controller
{
	public function loginAction()
	{
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');

		$user = Users::findFirst(
			[
				"username = :username: AND password = :password:",
				'bind' => [
					'username' => $username,
					'password' => sha1($password)
				]
			]
		);

		if ($user != false) {

			$this->session->set(
				'auth',
				[
					'id'   => $user->id,
					'name' => $user->username
				]
			);

			$this->flash->success('Welcome ' . $user->username);

			return $this->dispatcher->forward(
				[
					'controller' => 'index',
					'action'     => 'index'
				]
			);
		}

		$this->flash->error('Wrong email/password');
	}
}