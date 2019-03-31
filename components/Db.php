<?php

/**
 * Description of Db
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Db {
    //put your code here
    public static function getConnection(){
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        $dsn = "mysql:host={$params['host']};dbname={$params['db_name']}";
        $db = new PDO($dsn, $params['name'], $params['password']);
        return $db;
    }
}
