<?php

/**
 * Description of Product
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Product {
    const SHOW_BY_DEFAULT = 6;
    
    public static function getLatest($limit = self::SHOW_BY_DEFAULT){
       $limit = intval($limit);
        
        $query = "SELECT `id`, `name`, `price`, `image`, `is_new` "
                . "FROM `product` WHERE `status` = 1 ORDER BY `id` DESC"
                . " LIMIT {$limit}; ";
        $db = Db::getConnection();
        $res = $db->query($query);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $products = [];
        while ($row = $res->fetch()) {
            array_push($products, $row);
        }
        return $products;
    }
    
    public static function getProductsByCategoryId($categoryId){
        //Utils::debug($categoryId);
        $db = Db::getConnection();
        $statement = $db->prepare("SELECT `id`, `name`, `price`, `image`, `is_new` "
                . "FROM `product` WHERE `status` = 1 AND `category_id` = :category_id"
                . " ORDER BY `id` DESC LIMIT :lim ");
        $lim = self::SHOW_BY_DEFAULT;
        $statement->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindParam(':lim', $lim, PDO::PARAM_INT);
        $products = [];
        $res = $statement->execute();
        
        if($res){
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        
        //Utils::debug($products);
        return $products;
    }
}
