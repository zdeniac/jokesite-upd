<?php
//a bejelentkezés hitelesítésének osztálya

namespace Ninja;

use \Ninja\DatabaseTable as DatabaseTable;


class Authentication
{


	private $users;
	private $usernameColumn;
	private $passwordColumn;


	public function __construct(DatabaseTable $users, string $usernameColumn, string $passwordColumn) {

		session_start();
		$this->users = $users;
		$this->usernameColumn = $usernameColumn;
		$this->passwordColumn = $passwordColumn;

	}

	public function login(string $username, string $password): bool {

		$user = $this->users->find($this->usernameColumn, strtolower($username));

		if (!empty($user) && password_verify($password, $user[0][$this->passwordColumn])) {
			
			session_regenerate_id();
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $user[0][$this->passwordColumn];

			return true;

		}
		else {

			return false;

		}

	}

	public function isLoggedIn(): bool {

		if (empty($_SESSION['username'])) {
			
			return false;

		}

		$user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));

		if (!empty($user) && $user[0][$this->passwordColumn] === $_SESSION['password']) {

			return true;

		}
		else {

			return false;

		}

	}

}