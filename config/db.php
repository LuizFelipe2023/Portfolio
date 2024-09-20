<?php

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'portfolio'; 
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $this->conn = new PDO($dsn, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Conexão com o banco de dados estabelecida com sucesso.";
        } catch (PDOException $e) {
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
