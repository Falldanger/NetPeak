<?php

namespace database;

include_once './Connection.php';

use database\Connection as Connection;
use PDO;
use PDOException;

try {
    $dbConnection = Connection::getInstance();
    $sql = "CREATE TABLE IF NOT EXISTS products (
                id int(11) AUTO_INCREMENT PRIMARY KEY,
                product_name varchar(128) NOT NULL,
                image varchar(255),
                creator_name varchar(64) NOT NULL,
                avg_price float NOT NULL, 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
    $dbConnection->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS comments (
                id int(11) AUTO_INCREMENT PRIMARY KEY,
                product_id int(11) NOT NULL,
                commentator_name varchar(64) NOT NULL,
                mark int(2) NOT NULL,
                message text NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
    $dbConnection->exec($sql);
    echo "DB created successfully";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
