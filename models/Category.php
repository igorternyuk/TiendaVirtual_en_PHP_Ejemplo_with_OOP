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
    
    public static function addNew($name, $rating = 1, $status = 1){
        $db = Db::getConnection();
        $query = "INSERT INTO `category`  (`name`, `rating`, `status`)"
                . " VALUES(:name, :rating, :status);";
        $statement = $db->prepare($query);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':rating', $rating, PDO::PARAM_INT);
        $statement->bindParam(':status', $status, PDO::PARAM_INT);
        return $statement->execute();
    }
    
    public static function update($id, $name, $rating = 1, $status = 1){
        $db = Db::getConnection();
        $query = "UPDATE `category` SET `name` = :name, `rating` = :rating,"
                . "`status` = :status WHERE `id` = :id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':rating', $rating, PDO::PARAM_INT);
        $statement->bindParam(':status', $status, PDO::PARAM_INT);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        return $statement->execute();
    }

    public static function removeById($categoryId){
        $db = Db::getConnection();
        $query = "DELETE * FROM `category` WHERE `id` = :id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $categoryId, PDO::PARAM_INT);
        return $statement->execute();
    }
}
