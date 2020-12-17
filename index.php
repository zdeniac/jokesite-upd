<?php
	
function loadTemplate(string $templateFileName, array $variables = []){

	extract($variables);

	ob_start();

	include __DIR__.'\\templates\\' . $templateFileName;

	return ob_get_clean();

}	


try {
	
	include __DIR__ .'/includes/DatabaseConnection.php';
	include __DIR__ .'/classes/DatabaseTable.php';
	include __DIR__ .'/controllers/JokeController.php';


	$jokesTable = new DatabaseTable($pdo, 'joke');
	$authorsTable = new DatabaseTable($pdo, 'author');

	$jokeController = new JokeController($jokesTable, $authorsTable);

	$action = $_GET['action'] ?? 'home';
	$page = $jokeController->$action();

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