<?php

	if (isset($_POST['text'])) {
		
		try {
				
			include __DIR__ .'/includes/DatabaseConnection.php';
			include __DIR__ .'/includes/DatabaseFunctions.php';

			insert($pdo, 'joke', ['text' => $_POST['text'], 'author_id' => 3, 'date' => new DateTime()]);
			header('Location: jokes.php');

		}
		catch (PDOException $e) {
			
			$title = 'Hiba!';
			$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';

		}
		
	}
	else {
	
		$title = 'Vicc feltöltése';

		ob_start();

		include __DIR__ . '/templates/addjoke.html.php';

		$output = ob_get_clean();

	}

	include __DIR__ . '/templates/layout.html.php';
