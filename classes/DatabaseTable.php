<?php

	class DatabaseTable {


		public $connection;
		public $table;
		public $primaryKey;


		public function __construct(PDO $connection, string $table, string $primaryKey = 'id') {

			$this->connection = $connection;
			$this->table = $table;
			$this->primaryKey = $primaryKey;

		}

		private function query(string $sql, array $parameters = []): PDOStatement {

			$query = $this->connection->prepare($sql);
			$query->execute($parameters);

			//$this->connection = null;

			return $query;
		}

		public function findAll(): array {

			$sql = 'SELECT * FROM `' . $this->table . '`';
			$result = $this->query($sql);

			return $result->fetchAll();
		}

		public function delete(string $id) {

			$sql = 'DELETE FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :' . $this->primaryKey;
			$parameters = [':'. $this->primaryKey => $id];

			$this->query($sql, $parameters);
		}

		public function insert(array $fields) {

			$sql = 'INSERT INTO `' . $this->table . '` (';

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
			$fields = $this->processDates($fields);

			$this->query($sql, $fields);
		}

		public function findById(int $id): array {

			$sql = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :' . $this->primaryKey;
			$parameters = [':' . $this->primaryKey => $id];

			$query = $this->query($sql, $parameters);

			return $query->fetch();
		}


		public function update(array $fields, int $id) {

			$sql = 'UPDATE `' . $this->table . '` SET ';
			
			foreach ($fields as $key => $value) {
				
				$sql .= '`' . $key .'` = :' . $key . ',';
			}

			$sql = rtrim($sql, ',');
			$sql .= ' WHERE '. $this->primaryKey .' = :primaryKey';

			//be kell állítani az elsődleges kulcsot, mert az 'id' mező már foglalt a paraméterek közt
			$fields['primaryKey'] = $id;

			$fields = $this->processDates($fields);

			$this->query($sql, $fields);

		}

		public function save(array $record, string $id) {

			try {
				//ha a hidden mezőn keresztül üres érték került be, az auto_increment NULL-t kap
				if ($record[$this->primaryKey] == '') {
					$record[$this->primaryKey] = null;
				}
				$this->insert($record);
			}
			catch (connectionException $e) {
				$this->update($record, $id, $this->primaryKey);
			}

		}

		public function total(): string {

			$sql = 'SELECT COUNT(*) FROM `' . $this->table . '`';
			$query = $this->query($sql);
			$row = $query->fetch();

			return $row[0];
		}

		private function processDates(array $fields) {

			foreach ($fields as $key => $value) {

				if ($value instanceof DateTime) {

					$value->setTimezone(new DateTimeZone('Europe/Budapest'));
					$fields[$key] = $value->format('Y-m-d H:i:s');

				}
			}

			return $fields;
		}



	}