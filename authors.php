<?php

	try {

		include __DIR__ .'/includes/DatabaseConnection.php';
		include __DIR__ .'/includes/DatabaseFunctions.php';

    	$authors = findAll($pdo, 'author');
		$countAuthors = countJokes($pdo);

		$title = 'Szerzők listája';

		ob_start();

		include __DIR__ . '/templates/authors.html.php';

		$output = ob_get_clean();

	}
	catch (PDOException $e) {
		
		$title = 'Hiba!';
		$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';
	
	}


	include __DIR__ . '/templates/layout.html.php';
