<?php
namespace Core;

abstract class Model {
    protected static $db;

    public static function setDB($config) {
        self::$db = new \PDO($config['dsn'], $config['user'], $config['password']);
    }
}
