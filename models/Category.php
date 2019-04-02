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
}
