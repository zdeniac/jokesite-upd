<?php

namespace JokeSite\Controllers;
use \Ninja\DatabaseTable;

class Register
{


	private $authorsTable;


	public function __construct(DatabaseTable $authorsTable) {

		$this->authorsTable = $authorsTable;

	}

	public function registrationForm(): array {

		return ['template' => 'register.html.php',
				'title' => 'Regisztráció'
		];

	}

	public function success(): array {

		return ['template' => 'registersuccess.html.php',
				'title' => 'Sikeres regisztráció!'
		];

	}

	public function registerUser() {

		$author = $_POST['author'];
		$this->authorsTable->save($author);

		header('Location: /novice_to_ninja/author/success');

	}


}	