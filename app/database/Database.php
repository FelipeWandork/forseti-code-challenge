<?php

namespace app\database;

use \PDO;
use \PDOException;

class Database {
	const HOST 	 = "localhost";
	const NAME 	 = "forseti";
	const PORT	 = "3307";
	const USER	 = "forseti";
	const PASS	 = "RJ-2022@forseti";


	private $table;

	private $connection;

	public function __construct($table = null) {

		$this->table = $table;

		$this->setConnection();

	}

	private function setConnection(){
		try {
			$dsn = "mysql:host=".self::HOST.";dbname=".self::NAME.";port=".self::PORT.";charset=utf8mb4";

			$this->connection = new PDO($dsn, self::USER, self::PASS);

			$this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $error) {

			//alterar esta mensagem para produção
			die ("ERROR: ".$error->getMessage());

		}
	}

	public function execute($query, $params = []){

		try {

			$statement = $this->connection->prepare($query);

			$statement->execute($params);

			return $statement;

		} catch(PDOException $error) {

			die("ERROR: ".$error->getMessage());

		}
	}

	public function select($where = null, $order = null, $limit = null, $fields = "*"){

		$where = strlen($where) ? "WHERE ".$where : "";

		$order = strlen($order) ? "ORDER BY ".$order : "";

		$limit = strlen($limit) ? "LIMIT ".$limit : "";

		$query = "SELECT ".$fields." FROM ".$this->table." ".$where." ".$order." ".$limit;

		return $this->execute($query);
	}

	public function insert($data){

		$fields = array_keys($data);

		$values = array_pad([],count($fields),"?");

		$query = "INSERT INTO ".$this->table." (".implode(",",$fields).") VALUES (".implode(",",$values).");";

		$this->execute($query, array_values($data));

		return $this->connection->lastInsertId();
	}

	public function update($where, $values){

		$fields = array_keys($values);

		$query  = "UPDATE ".$this->table." SET ".implode("=?, ",$fields)."=? WHERE ".$where;

		$this->execute($query, array_values($values));

		return true;
	}

	public function del($where){

		$query = "DELETE FROM ".$this->table." WHERE ".$where;

		$this->execute($query);

		return true;


	}
}
