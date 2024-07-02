<?php
function getDatabaseConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test_db";

    try {
        // Connect to MySQL server
        $dsn = "mysql:host=$servername;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create database if it doesn't exist
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
        $pdo->exec("USE $dbname");

        // Create table if it doesn't exist
        $createTableSQL = "
            CREATE TABLE IF NOT EXISTS estoque (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL,
                produto VARCHAR(100) NOT NULL,
                cor VARCHAR(100) NOT NULL,
                tamanho VARCHAR(100) NOT NULL,
                deposito VARCHAR(100) NOT NULL,
                data_disponibilidade DATE NOT NULL,
                quantidade INT UNSIGNED NOT NULL,
                PRIMARY KEY (id),
                UNIQUE KEY estoque_un (produto, cor, tamanho, deposito, data_disponibilidade)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci
        ";
        $pdo->exec($createTableSQL);

        return $pdo;
    } catch (PDOException $e) {
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
}

?>
