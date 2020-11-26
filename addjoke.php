<?php

	if (isset($_POST['joketext'])) {
		
		try {
				
			$pdo = new PDO('mysql:host=localhost;port=3308;dbname=jokes_crud;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

			$sql = 'INSERT INTO `joke` SET `text` = :joketext';

			$stmt = $pdo->prepare($sql);

			$stmt->bindValue(':joketext', $_POST['joketext']);
			$stmt->execute();

			$pdo = null;

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
