<?php

/**
 * Description of Db
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Db {
    
    public static function getConnection(){
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        $dsn = "mysql:host={$params['host']};dbname={$params['db_name']}";
        $db = new PDO($dsn, $params['username'], $params['password']);
        $db->exec("set names utf8");
        return $db;
    }
    
    public static function executeSelection($query){
        
    }
    
    public static function executeUpdate($query){
    }
    
    /*
function executeSelection($query){
    $db = Database::getInstance();
    $connection = $db->getConnection();
    $rs = $connection->query($query);
    $smartyRs = fetchSmartyArray($rs);
    $db->closeConnection();
    return $smartyRs;
}

function executeUpdate($sql){
    $db = Database::getInstance();
    $connection = $db->getConnection();
    $connection->query($sql);
    $errorOccured = mysqli_error($connection);
    $db->closeConnection();
    return $errorOccured ? false : true;
}
*/
}
