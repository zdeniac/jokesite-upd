<?php
	
	try {
		
		include __DIR__ .'/includes/DatabaseConnection.php';
		include __DIR__ .'/classes/DatabaseTable.php';


		$joke = new DatabaseTable($pdo, 'joke');
		$joke->delete($_POST['id']);
		
		header('Location: jokes.php');


	}
	catch (PDOException $e) {
		$title = 'Hiba!';
		$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';
	}

	include __DIR__ . '/templates/layout.html.php';