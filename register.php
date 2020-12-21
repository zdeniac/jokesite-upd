<?php
try {
	
	include __DIR__ .'/includes/DatabaseConnection.php';
	include __DIR__ .'/classes/DatabaseTable.php';
	include __DIR__ .'/controllers/RegisterController.php';


	$jokesTable = new DatabaseTable($pdo, 'joke');
	$authorsTable = new DatabaseTable($pdo, 'author');

	$registerController = new RegisterController($authorsTable);

	$action = $_GET['action'] ?? 'home';

	if ($action == strtolower($action)) {
		$page = $registerController->$action();
	}
	else {
		http_response_code(301);
		header('Location: index.php?action=' . strolower($action));
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