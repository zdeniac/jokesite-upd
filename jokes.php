<?php

	try {

		include __DIR__ .'/includes/DatabaseConnection.php';
		include __DIR__ .'/includes/DatabaseFunctions.php';

    	$results = findAll($pdo, 'joke');
    	
    	$jokes = [];

    	foreach ($results as $joke) {
    
    		$author = findById($pdo, 'author', $joke['author_id']);
    		$jokes[] = [
    			'id' => $joke['id'], 
    			'text' => $joke['text'], 
    			'date' => $joke['date'], 
    			'name' => $author['name'], 
    			'email' => $author['name']
    		];

    	}


		$countJokes = countJokes($pdo);

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
