<?php

	try {

		include __DIR__ .'/includes/DatabaseConnection.php';
		include __DIR__ .'/includes/DatabaseFunctions.php';


		$sql = "SELECT `joke`.`id`, `text`, `name`, `email` FROM `joke` INNER JOIN `author` ON `author_id` = `author`.`id` INNER JOIN `email` ON `email`.`author_id` = `author`.`id`";
    	$jokes = $pdo->query($sql);
		$totalJokes = totalJokes($pdo);

		$pdo = null;

		$title = 'Viccek listája';

		ob_start();

		include __DIR__ . '/templates/jokes.html.php';

		$output = ob_get_clean();

	}
	catch (PDOException $e) {
		
		$title = 'Hiba!';
		$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';
	
	}


	include __DIR__ . '/templates/layout.html.php';
