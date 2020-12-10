<?php

	include __DIR__ .'/includes/DatabaseConnection.php';
	include __DIR__ .'/includes/DatabaseFunctions.php';

		
	try {
			
		if (isset($_POST['joke']['text'])) {

			$joke = $_POST['joke'];
			$joke['author_id'] = 1;
			$joke['date'] = new DateTime();
			
			save($pdo, 'joke', $joke, $joke['id'], 'id');
			header('Location: jokes.php');

		}
		else {

			if (isset($_GET['id'])) {
				
				$joke = findById($pdo, 'joke', $_GET['id']);

			}


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
