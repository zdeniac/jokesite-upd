<?php

	include __DIR__ .'/includes/DatabaseConnection.php';
	include __DIR__ .'/includes/DatabaseFunctions.php';

		
	try {
			
		if (isset($_POST['text'])) {
			
			updateJoke($pdo, ['id' => $_POST['id'], 'text' => $_POST['text'], 'author_id' => 1, 'date' => new DateTime]);
			header('Location: jokes.php');

		}
		else {

			$joke = getJoke($pdo, $_GET['id']);

			$title = 'Vicc szerkesztése';

			ob_start();

			include __DIR__ . '/templates/editjoke.html.php';

			$output = ob_get_clean();

		}

	}
	catch (PDOException $e) {
		
		$title = 'Hiba!';
		$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';

	}
		
	include __DIR__ . '/templates/layout.html.php';
