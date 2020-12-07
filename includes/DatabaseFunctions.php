<?php

	function query(PDO $pdo, string $sql, array $parameters = []): PDOStatement {

		$query = $pdo->prepare($sql);
		$query->execute($parameters);

		return $query;
	}

	function totalJokes(PDO $pdo) {

		$query = query($pdo, 'SELECT COUNT(*) FROM `joke`');
		$row = $query->fetch();

		return $row[0];
	}

	function getJoke(PDO $pdo, $id) {

		$parameters = [':id' => $id];
		$query = query($pdo, 'SELECT * FROM `joke` WHERE id = :id', $parameters);

		return $query->fetch();
	}

	function insertJoke(PDO $pdo, string $jokeText, $authorId) {

		$query = 'INSERT INTO `joke`(`text`, `author_id`) VALUES(:jokeText, :authorId)';
		$parameters = [':text' => $jokeText, ':authorId' => $authorId];

		query($pdo, $query, $parameters);
	}