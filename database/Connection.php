<?php

namespace database;

use PDO;

/**
 * Class Connection
 * @package database
 */
class Connection
{
    private static $db = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (self::$db === null) {
            self::$db = new PDO("mysql:host=localhost;" . 'dbname=netpeak', 'root', 'root');
        }

        return self::$db;
    }
}
