<?php

	try {

		include __DIR__ .'/includes/DatabaseConnection.php';
		include __DIR__ .'/classes/DatabaseTable.php';


		$jokesTable = new DatabaseTable($pdo, 'joke');
		$authors = new DatabaseTable($pdo, 'author');
		$emails = new DatabaseTable($pdo, 'email');

    	$jokes = [];

    	foreach ($jokesTable->findAll() as $joke) {

    		$author = $authors->findById($joke['author_id']);
    		$email = $emails->findById($joke['author_id']);

    		$jokes[] = [
    			'id' => $joke['id'], 
    			'text' => $joke['text'], 
    			'date' => $joke['date'], 
    			'name' => $author['name'],
    			'email' => $email['email']
    		];

    	}

		$countJokes = $jokesTable->total();

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
