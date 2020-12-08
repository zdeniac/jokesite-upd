<?php

	if (isset($_POST['joketext'])) {
		
		try {
				
			include __DIR__ .'/includes/DatabaseConnection.php';
			include __DIR__ .'/includes/DatabaseFunctions.php';

			insertJoke($pdo, $_POST['joketext'], 1);
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
