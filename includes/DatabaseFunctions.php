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


	function updateJoke(PDO $pdo, array $fields) {

		$sql = 'UPDATE `joke` SET ';
		
		foreach ($fields as $key => $value) {
			
			$sql .= '`' . $key .'` = :' . $key . ',';
		}

		$sql = rtrim($sql, ',');
		$sql .= ' WHERE `id` = :primaryKey';

		//be kell állítani az elsődleges kulcsot, mert az 'id' mező már foglalt a paraméterek közt
		$fields['primaryKey'] = $fields['id'];
		$fields = processDates($fields);

		query($pdo, $sql, $fields);
	}

	function allJokes(PDO $pdo): array {

		$sql = 'SELECT `joke`.`id`, `text`, `name`, `date`, `email` FROM `joke` INNER JOIN `author` ON `author_id` = `author`.`id` INNER JOIN `email` ON `email`.`author_id` = `author`.`id` ORDER BY `date` DESC';
		$jokes = query($pdo, $sql);

		return $jokes->fetchAll();
	}

//-------------------- HELPERS ----------------------------

	function processDates(array $fields) {

		foreach ($fields as $key => $value) {

			if ($value instanceof DateTime) {

				$value->setTimezone(new DateTimeZone('Europe/Budapest'));
				$fields[$key] = $value->format('Y-m-d H:i:s');

			}
		}

		return $fields;
	}

	function findAll(PDO $pdo, string $table): array {

		$sql = 'SELECT * FROM ' . $table;
		$result = query($pdo, $sql);

		return $result->fetchAll();
	}

	function delete(PDO $pdo, string $table, int $id, string $primaryKey = 'id') {

		$sql = 'DELETE FROM `' . $table . '` WHERE `' . $primaryKey . '`=:id';
		$parameters = [':id' => $id];

		query($pdo, $sql, $parameters);
	}

	function insert(PDO $pdo, string $table, array $fields) {

		$sql = 'INSERT INTO `' . $table . '` (';

		foreach ($fields as $key => $value) {
			$sql .= '`' . $key . '`,';
		}
		$sql = rtrim($sql, ',');

		$sql .= ') VALUES (';
		foreach ($fields as $key => $value) {
			$sql .= ':' . $key . ',';
		}
		$sql = rtrim($sql, ',');
		$sql .= ')';

		//DateTime elkészítése
		$fields = processDates($fields);

		query($pdo, $sql, $fields);
	}

	function update(PDO $pdo, string $table, array $fields, int $where, string $primaryKey = 'id') {

		$sql = 'UPDATE `' . $table . '` SET ';
		
		foreach ($fields as $key => $value) {
			
			$sql .= '`' . $key .'` = :' . $key . ',';
		}

		$sql = rtrim($sql, ',');
		$sql .= ' WHERE '. $primaryKey .' = :primaryKey';

		//be kell állítani az elsődleges kulcsot, mert az 'id' mező már foglalt a paraméterek közt
		$fields['primaryKey'] = $where;

		$fields = processDates($fields);

		query($pdo, $sql, $fields);

	}