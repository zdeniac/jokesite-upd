<?php
//route-okat tartalmazó osztály
//REST --> Representational State Transfer

namespace JokeSite;

use \Ninja\DatabaseTable as DatabaseTable;
use \Ninja\Authentication as Authentication;

use \JokeSite\Controllers\Joke as JokeController;
use \JokeSite\Controllers\Register as RegisterController;


class Routes implements \Ninja\Routes
{


	private $authorsTable;
	private $jokesTable;
	private $authenticaton;

	
	public function __construct() {

		require __DIR__ . '/../../includes/DatabaseConnection.php';

		$this->jokesTable = new DatabaseTable($pdo, 'joke', 'id');
		$this->authorsTable = new DatabaseTable($pdo, 'author', 'id');
		$this->authenticaton = new Authentication($this->authorsTable, 'email', 'password');

	}

	public function getRoutes(): array {


		$jokeController = new JokeController($jokesTable, $authorsTable);
		$authorController = new RegisterController($authorsTable);


		$routes = [

			'novice_to_ninja/author/register' => [
				'POST' => [
					'controller' => $authorController,
					'action' => 'registerUser'
				],
				'GET' => [
					'controller' => $authorController,
					'action' => 'registrationForm'
				]
			],

			'novice_to_ninja/author/success' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'success'
				]
			],

			'novice_to_ninja/joke/edit' => [
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

			'novice_to_ninja/joke/delete' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'delete'
				],
				'login' => true
			],

			'novice_to_ninja/joke/list' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'list'
				]
			],

			'novice_to_ninja/joke/home' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'home'
				]
			],

			'novice_to_ninja/' => [
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