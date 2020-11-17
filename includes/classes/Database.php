<?php

class Database {

    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $charset;
    private $pdo;

    protected function connect() {

        if ($this->pdo != null) {
            return $this->pdo;
        }

        $this->hostname = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "cinema-management-db";
        $this->charset = "utf8mb4";

        try {
            // Data Source Name
            $dsn = "mysql:host=$this->hostname;dbname=$this->dbname;charset=$this->charset";

            // PDO Config
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo = $pdo;
            return $this->pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

}
