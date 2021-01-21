<?php

namespace JokeSite\Controllers;

use \Ninja\Authentication;


class Login
{

	
	private $authentication;
	//localhost miatt kell
	private $site = '/novice_to_ninja';


	public function __construct(Authentication $authentication) {

		$this->authentication = $authentication;

	}

	public function error(): array {

		return [
			'template' => 'loginerror.html.php',
			'title' => 'Hiba történt a bejelentkezéskor!'
		];

	}

	public function loginForm(): array {

		return [
			'template' => 'login.html.php',
			'title' => 'Bejelentkezés'
		];

	}

	public function processLogin() {

		if ($this->authentication->login($_POST['email'], $_POST['password'])) {

			header('location: ' . $this->site . '/login/success');

		}
		else {
		
			return [
				'template' => 'login.html.php',
				'title' => 'Sikertelen bejelentkezés!',
				'variables' => [
					'error' => 'Nem megfelelően adta meg a jelszavát vagy a felhasználónevét!'
				]
			];

		}

	}

	public function logout(): array {

		session_unset();
		// $_SESSION = [];
		//session_destroy();

		return [
			'template' => 'login.html.php',
			'title' => 'Sikeres kijelentkezés!'
		];

	}

	public function success(): array {

		return ['template' => 'loginsuccess.html.php', 'title' => 'Sikeres bejelentkezés!'];
	
	}

}