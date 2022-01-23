<?php

namespace App;
USE PDO;

class DB
{
    public $connection;

    public function __construct()
    {
        $db_name = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASSWORD;
        $host = DB_HOST;

        try {
            $dbh = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
            $this->connection = $dbh;
        } catch (PDOException $e) {
            echo "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}