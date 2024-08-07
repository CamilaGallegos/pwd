<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'guemes_db';
    private $username = 'root';
    private $password = '21dia01mes';
    private $pdo;

    public function getConnection() {
        $this->pdo = null;

        try {
            $this->pdo = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
        }

        return $this->pdo;
    }
}

/*class Database {
    private $pdo;

    public function __construct() {
        $config = require __DIR__ . '/config.php';
        $dbConfig = $config['database'];

        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
        $this->pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection() {
        return $this->pdo;
    }
}*/