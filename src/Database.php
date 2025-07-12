<?php

class DataBase
{
    private static ?PDO $pdo = null;

    public static function getConnection()
    {
        if (self::$pdo === null) {
            $config = require APP_PATH . '/config/database.php';

            $host = $config['db_host'];
            $dbname = $config['db_name'];
            $user = $config['db_user'];
            $pass = $config['db_pass'];

            $cred = "mysql:host=$host;dbname=$dbname";

            try {
                self::$pdo = new PDO($cred, $user, $pass, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
