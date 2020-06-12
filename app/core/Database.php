<?php

class Database {

    private $db;
    private $stmt;

    public function __construct() {
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public function query($query) {
        $this->stmt = $this->db->prepare($query);
    }

    public function bind($param, $value) {
        $this->stmt->bindValue($param, $value);
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function execute($args = []) {
        if(empty($args)) {
            return $this->stmt->execute();
        } else {
            return $this->stmt->execute($args);
        }        
    }

    public function result($arg = []){
		if(empty($arg)){
			$this->execute();
		} else {
			$this->execute($arg);
		}
		return $this->stmt->fetchAll();
	}

    public function single() {
        $this->stmt->execute();
        return $this->stmt->fetch();
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

}