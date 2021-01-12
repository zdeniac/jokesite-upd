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

		$valid = true;
		$errors = [];

		if (count($this->authorsTable->find('email', $author['email'])) > 0) {
			$valid = false;
			$errors[] = 'Az email cím foglalt!';
		}

		if (empty($author['name'])) {
			$valid = false;
			$errors[] = 'Nem adta meg a nevét!';
		}

		$author['email'] = strtolower($author['email']);

		if (empty($author['email'])) {
			$valid = false;
			$errors[] = 'Nem adta meg az e-mail címét!';
		}
		else if (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
			$valid = false;
			$errors[] = 'Nem megfelelő e-mail címet adott meg!';
		}

		if (empty($author['password'])) {
			$valid = false;
			$errors[] = 'Nem adta meg a jelszavát!';
		}

		if ($valid === true) {

			$author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);

			$this->authorsTable->save($author);
			
			header('Location: /novice_to_ninja/author/success');

		}
		else {
			return ['template' => 'register.html.php',
					'title' => 'Regisztráció',
					'variables' => [
						'author' => $author,
						'errors' => $errors
					]
			];

		}

	}


}	