<?php

/**
 * Description of OrderItem
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class OrderItem {
    public static function createNew($orderID, $productId, $productCount){
        $db = Db::getConnection();
        $query = "INSERT INTO `order_item` (`order_id`, `product_id`, `count`)"
                . " VALUES(:order_id, :product_id, :count);";
        $statement = $db->prepare($query);
        $statement->bindParam(':order_id', $orderID, PDO::PARAM_INT);
        $statement->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $statement->bindParam(':count', $productCount, PDO::PARAM_INT);
        return $statement->execute();
    }
    
    public static function getAllItemsByOrderId($orderId){
        
    }
}
