<?php

namespace Source\Db;

use \Exception;
use \PDO;

class Connection
{

    private static $pdo;

    private function __construct()
    {
    }

    public static function getInstance()
    {

        if (!isset(self::$pdo)) {

            try {

                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE =>
                    PDO::ERRMODE_EXCEPTION);

                self::$pdo = new PDO("mysql:host=" . DBHOST . "; dbname=" . DBNAME . "; charset=utf8;", DBUSER, DBPASSWORD, $options);

            } catch (PDOException $e) {
                throw new Exception("Error: " . $e->getMessage(), 500);
            }

        }

        return self::$pdo;

    }

}
