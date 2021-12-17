<?php

class Database {
    private static $dbName = 'technicien_portfolio';
    private static $dbHost = 'localhost';
    private static $port = '8889';
    private static $dbUsername = 'root';
    private static $dbUserPassword = 'root';
    private static $cont = null;

    public static function connect() {
        if ( null == self::$cont ) {
            try {
                self::$cont = new PDO(
                    "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName . ";port=" . self::$port, 
                    self::$dbUsername, self::$dbUserPassword
                );

            } catch(PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect() {
        self::$cont = null;
    }
}
?>
