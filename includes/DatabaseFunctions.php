<?php

	function query(PDO $pdo, string $sql, array $parameters = []): PDOStatement {

		$query = $pdo->prepare($sql);
		$query->execute($parameters);

		$pdo = null;

		return $query;
	}

		function findAll(PDO $pdo, string $table): array {

		$sql = 'SELECT * FROM ' . $table;
		$result = query($pdo, $sql);

		return $result->fetchAll();
	}

	function delete(PDO $pdo, string $table, string $keyVal, string $primaryKey = 'id') {

		$sql = 'DELETE FROM `' . $table . '` WHERE `' . $primaryKey . '` = :' .$primaryKey;
		$parameters = [':'.$primaryKey => $keyVal];

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

	function findById(PDO $pdo, string $table, string $keyVal, string $primaryKey = 'id'): array {

		$sql = 'SELECT * FROM `' . $table . '` WHERE `' . $primaryKey . '` = :'.$primaryKey;
		$parameters = [':'.$primaryKey => $keyVal];

		$query = query($pdo, $sql, $parameters);

		return $query->fetch();
	}


	function update(PDO $pdo, string $table, array $fields, string $keyVal, string $primaryKey = 'id') {

		$sql = 'UPDATE `' . $table . '` SET ';
		
		foreach ($fields as $key => $value) {
			
			$sql .= '`' . $key .'` = :' . $key . ',';
		}

		$sql = rtrim($sql, ',');
		$sql .= ' WHERE '. $primaryKey .' = :primaryKey';

		//be kell állítani az elsődleges kulcsot, mert az 'id' mező már foglalt a paraméterek közt
		$fields['primaryKey'] = $keyVal;

		$fields = processDates($fields);

		query($pdo, $sql, $fields);

	}

	function save(PDO $pdo, string $table, array $record, string $keyVal, string $primaryKey = 'id') {

		try {
			if ($record[$primaryKey] == '') {
				$record[$primaryKey] = null;
			}
			insert($pdo, $table, $record);
		}
		catch (PDOException $e) {
			update($pdo, $table, $record, $keyVal, $primaryKey);
		}

	}

	function countJokes(PDO $pdo): string {

		$sql = 'SELECT COUNT(*) FROM `joke`';
		$query = query($pdo, $sql);
		$row = $query->fetch();

		return $row[0];
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