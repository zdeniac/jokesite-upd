<?php
//route-okat tartalmazó osztály
//REST --> Representational State Transfer

namespace JokeSite;


class Routes implements \Ninja\Routes {


	public function getRoutes(): array {

		require __DIR__ . '/../../includes/DatabaseConnection.php';

		$jokesTable = new \Ninja\DatabaseTable($pdo, 'joke');
		$authorsTable = new \Ninja\DatabaseTable($pdo, 'author');

		$jokeController = new \JokeSite\Controllers\Joke($jokesTable, $authorsTable);
		$authorController = new \JokeSite\Controllers\Register($authorsTable);


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
				]
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
			],

			'novice_to_ninja/joke/delete' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'delete'
				]
			],

		];

		return $routes;

	}


}