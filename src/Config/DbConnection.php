<?php


namespace Victor\AluraPhpExampleSerenatto\Config;

use PDO;
use PDOException;

class DbConnection {
    private $pdo;

    private $host = '127.0.0.1';
    private $db = 'serenatto';
    private $user = 'root';
    private $password = 'mysql';
    private $charset = 'utf8mb4';
    private $dsn;
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public function __construct() {
        $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        
        try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->password, $this->options);
        } catch (PDOException $e) {
            throw new PDOException("Erro na conexão: " . $e->getMessage());
        }
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }
}

