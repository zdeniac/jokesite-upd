<?php
	
	try {
		
		include __DIR__ .'/includes/DatabaseConnection.php';
		include __DIR__ .'/includes/DatabaseFunctions.php';


		delete($pdo, 'author', $_POST['id']);
		header('Location: authors.php');


	}
	catch (PDOException $e) {
		$title = 'Hiba!';
		$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';
	}

	include __DIR__ . '/templates/layout.html.php';