<?php

/**
 * Description of Category
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Category {
    public static function getAll(){
        $query = "SELECT * FROM `category` ORDER BY `rating` ASC;";
        $conneciton = Db::getConnection();
        $res = $conneciton->query($query);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $categories = [];
        while($row = $res->fetch()){
            array_push($categories, $row);
        }
        return $categories;
    }
    
    public static function getById($categoryId){
        $db = Db::getConnection();
        $query = "SELECT * FROM `category` WHERE `id` = :id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $categoryId);
        if($statement->execute()){
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    public static function addNew($options){
        $db = Db::getConnection();
        $query = "INSERT INTO `category`  (`name`, `rating`, `status`)"
                . " VALUES(:name, :rating, :status);";
        $statement = $db->prepare($query);
        $statement->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $statement->bindParam(':rating', $options['rating'], PDO::PARAM_INT);
        $statement->bindParam(':status', $options['status'], PDO::PARAM_INT);
        return $statement->execute();
    }
    
    public static function update($options){
        $db = Db::getConnection();
        $query = "UPDATE `category` SET `name` = :name, `rating` = :rating,"
                . "`status` = :status WHERE `id` = :id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $statement->bindParam(':rating', $options['rating'], PDO::PARAM_INT);
        $statement->bindParam(':status', $options['status'], PDO::PARAM_INT);
        $statement->bindParam(':id', $options['id'], PDO::PARAM_INT);
        if($statement->execute()){
            return true;
        } else {
            return $statement->errorInfo();
        }
    }

    public static function removeById($categoryId){
        $db = Db::getConnection();
        $query = "DELETE FROM `category` WHERE `id` = :id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $categoryId, PDO::PARAM_INT);
        return $statement->execute();
    }
    
    public static function countAll(){
        $db = Db::getConnection();
        $query = "SELECT COUNT(`id`) AS total FROM `category`";
        $statement = $db->prepare($query);
        if($statement->execute()){
            $res = $statement->fetch(PDO::FETCH_ASSOC);
            return $res['total'];
        }
        return 0;
    }
}
