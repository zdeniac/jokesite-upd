<?php
//route-okat tartalmazó osztály
//REST --> Representational State Transfer

namespace JokeSite;


use \Ninja\ {
	DatabaseTable,
	Authentication,
};

use \JokeSite\Controllers\ {
	Joke as JokeController,
	Register as RegisterController,
	Login as LoginController,
};



class Routes implements \Ninja\Routes
{


	private $authorsTable;
	private $jokesTable;
	private $authenticaton;
	//localhost miatt kell
	private $site = 'novice_to_ninja';

	
	public function __construct() {

		require __DIR__ . '/../../includes/DatabaseConnection.php';

		$this->jokesTable = new DatabaseTable($pdo, 'joke', 'id');
		$this->authorsTable = new DatabaseTable($pdo, 'author', 'id');
		$this->authenticaton = new Authentication($this->authorsTable, 'email', 'password');

	}

	public function getRoutes(): array {


		$jokeController = new JokeController($this->jokesTable, $this->authorsTable);
		$authorController = new RegisterController($this->authorsTable);
		$loginController = new LoginController($this->authenticaton);


		$routes = [

			$this->site . '/author/register' => [
				'POST' => [
					'controller' => $authorController,
					'action' => 'registerUser'
				],
				'GET' => [
					'controller' => $authorController,
					'action' => 'registrationForm'
				]
			],

			$this->site . '/author/success' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'success'
				]
			],

			$this->site . '/login' => [
				'POST' => [
					'controller' => $loginController,
					'action' => 'processLogin'
				],
				'GET' => [
					'controller' => $loginController,
					'action' => 'loginForm'
				]
			],

			$this->site . '/login/success' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'success'
				]
			],

			$this->site . '/login/error' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'error'
				]
			],

			$this->site . '/logout' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'logout'
				]
			],

			$this->site . '/joke/edit' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $jokeController,
					'action' => 'edit'
				],
				'login' => true
			],

			$this->site . '/joke/delete' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'delete'
				],
				'login' => true
			],

			$this->site . '/joke/list' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'list'
				]
			],

			$this->site . '/joke/home' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'home'
				]
			],

			$this->site . '/' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'home'
				]
			]

		];

		return $routes;

	}

	public function getAuthentication(): Authentication {

		return $this->authenticaton;

	}


}