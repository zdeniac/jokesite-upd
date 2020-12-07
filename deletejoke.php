<?php
	
	try {
		
		include __DIR__ .'/includes/DatabaseConnection.php';

		$sql = 'DELETE FROM `joke` WHERE id = :id';

		$stmt = $pdo->prepare($sql);

		$stmt->bindValue(':id', $_POST['id']);
		$stmt->execute();

		$pdo = null;

		header('Location: jokes.php');


	}
	catch (PDOException $e) {
		$title = 'Hiba!';
		$output = 'Adatbázis hiba: ' . $e->getMessage(); ' a ' . $e->getFile() . ' fájl ' . $e->getLine() . '. számú sorában.';
	}

	include __DIR__ . '/templates/layout.html.php';