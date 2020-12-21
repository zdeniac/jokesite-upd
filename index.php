<?php
function loadTemplate(string $templateFileName, array $variables = []){

	extract($variables);

	ob_start();

	include __DIR__.'\\templates\\' . $templateFileName;

	return ob_get_clean();

}

try {

	include __DIR__ . '/includes/DatabaseConnection.php';
	include __DIR__ . '/classes/DatabaseTable.php';


	$jokesTable = new DatabaseTable($pdo, 'joke');
	$authorsTable = new DatabaseTable($pdo, 'author');

	$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
	// var_dump($route);die;

	if ($route == strtolower($route)) {

		if ($route === '/joke/list') {
			include __DIR__ . '/controllers/JokeController.php';
			$controller = new JokeController($jokesTable, $authorsTable);
			$page = $controller->list();
		}
		else if ($route === '/joke/home') {
			include __DIR__ . '/controllers/JokeController.php';
			$controller = new JokeController($jokesTable, $authorsTable);
			$page = $controller->home();
		}
		else if ($route === '/joke/edit') {
			include __DIR__ . '/controllers/JokeController.php';
			$controller = new JokeController($jokesTable, $authorsTable);
			$page = $controller->edit();
		}
		else if ($route === '/joke/delete') {
			include __DIR__ . '/controllers/JokeController.php';
			$controller = new JokeController($jokesTable, $authorsTable);
			$page = $controller->delete();
		}
		else if ($route === '/register') {
			include __DIR__ . '/controllers/RegisterController.php';
			$controller = new RegisterController($authorsTable);
			$page = $controller->showForm();
		}

	}
	else {

		http_response_code(301);
		header('Location: index.php? route=' . $route);
	
	}

	$title = $page['title'];

	if (isset($page['variables'])) {
		$output = loadTemplate($page['template'], $page['variables']);
	}
	else {
		$output = loadTemplate($page['template']);
	}


}
catch (PDOException $e) {
	
	$title = 'Hiba!';
	$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';

}

include __DIR__ . '/templates/layout.html.php';