<?php

/**
 * Description of Product
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Product {
    const SHOW_BY_DEFAULT = 3;
    
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
    
    public static function getProductsByCategoryId($categoryId, $page){
        //Utils::debug($categoryId);
        $db = Db::getConnection();
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        $statement = $db->prepare("SELECT `id`, `name`, `price`, `image`, `is_new` "
                . "FROM `product` WHERE `status` = 1 AND `category_id` = :category_id"
                . " ORDER BY `id` DESC LIMIT :lim OFFSET :offset");
        $lim = self::SHOW_BY_DEFAULT;
        $statement->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindParam(':lim', $lim, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $products = [];
        $res = $statement->execute();
        
        if($res){
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        
        //Utils::debug($products);
        return $products;
    }
    
    public static function countProductsOfCategory($categoryId){
        $db = Db::getConnection();
        $statement = $db->prepare("SELECT COUNT(`id`) AS total FROM `product` WHERE"
                . " `status` = 1 AND `category_id` = :category_id");
        $statement->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $res = $statement->execute();
        $total = 0;
        if($res){
            $res = $statement->fetch(PDO::FETCH_ASSOC);
            $total = $res['total'];
        }
        return $total;
    }
    
    public static function getProductById($productId){
        $db = Db::getConnection();
        $statement = $db->prepare("SELECT * FROM `product` WHERE `status` = 1"
                . " AND `id` = :id LIMIT 1;");
        $statement->bindParam(':id', $productId, PDO::PARAM_INT);
        $res = $statement->execute();
        $product = false;
        if($res){
            $product = $statement->fetch(PDO::FETCH_ASSOC);
        }
        //Utils::debug($product);
        return $product;
    }
}
