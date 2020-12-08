<?php

	function query(PDO $pdo, string $sql, array $parameters = []): PDOStatement {

		$query = $pdo->prepare($sql);
		$query->execute($parameters);

		$pdo = null;

		return $query;
	}

	function countJokes(PDO $pdo): string {

		$sql = 'SELECT COUNT(*) FROM `joke`';
		$query = query($pdo, $sql);
		$row = $query->fetch();

		return $row[0];
	}

	function getJoke(PDO $pdo, $id): array {

		$sql = 'SELECT * FROM `joke` WHERE id = :id';
		$parameters = [':id' => $id];
		$query = query($pdo, $sql, $parameters);

		return $query->fetch();
	}

	function insertJoke(PDO $pdo, string $jokeText, int $authorId) {

		$sql = 'INSERT INTO `joke`(`text`, `author_id`) VALUES(:text, :author_id)';
		$parameters = [':text' => $jokeText, ':author_id' => $authorId];

		query($pdo, $sql, $parameters);
	}

	function updateJoke(PDO $pdo, $jokeId, string $jokeText, $authorId) {

		$sql = 'UPDATE `joke` SET `text` = :text, `author_id` = :author_id WHERE `id` = :id';
		$parameters = [':id' => $jokeId, ':text' => $jokeText, ':author_id' => $authorId];

		query($pdo, $sql, $parameters);
	}

	function deleteJoke(PDO $pdo, $jokeId) {

		$sql = 'DELETE FROM `joke` WHERE `id` = :id';
		$parameters = [':id' => $jokeId];

		query($pdo, $sql, $parameters);
	}

	function allJokes(PDO $pdo) {

		$sql = 'SELECT `joke`.`id`, `text`, `name`, `email` FROM `joke` INNER JOIN `author` ON `author_id` = `author`.`id` INNER JOIN `email` ON `email`.`author_id` = `author`.`id`';
		$jokes = query($pdo, $sql);

		return $jokes->fetchAll();
	}