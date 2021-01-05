<?php
//route-okat tartalmazó osztály

namespace JokeSite;

class Routes {

	public function callAction($route): array {

		require __DIR__ . '/../../includes/DatabaseConnection.php';

		$jokesTable = new \Ninja\DatabaseTable($pdo, 'joke');
		$authorsTable = new \Ninja\DatabaseTable($pdo, 'author');

		if ($route === 'novice_to_ninja/joke/list') {
			$controller = new \JokeSite\Controllers\Joke($jokesTable, $authorsTable);
			$page = $controller->list();
		}
		else if ($route === 'novice_to_ninja/joke/home' || $route === 'novice_to_ninja/') {
			$controller = new \JokeSite\Controllers\Joke($jokesTable, $authorsTable);
			$page = $controller->home();
		}
		else if ($route === 'novice_to_ninja/joke/edit') {
			$controller = new \JokeSite\Controllers\Joke($jokesTable, $authorsTable);
			$page = $controller->edit();
		}
		else if ($route === 'novice_to_ninja/joke/delete') {
			$controller = new \JokeSite\Controllers\Joke($jokesTable, $authorsTable);
			$page = $controller->delete();
		}
		else if ($route === 'novice_to_ninja/register') {
			$controller = new \JokeSite\Controllers\Register($authorsTable);
			$page = $controller->showForm();
		}
		else {
			http_response_code(404);
			die('404');
		}

		return $page;

	}

}