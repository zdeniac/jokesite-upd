<?php

	try {

		$pdo = new PDO('mysql:host=localhost;port=3308;dbname=jokes_crud;charset=utf8', 'root', '');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "SELECT `joke`.`id`, `text`, `name`, `email` FROM `joke` INNER JOIN `author` ON `authorid` = `author`.`id`";
		$jokes = $pdo->query($sql);

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
