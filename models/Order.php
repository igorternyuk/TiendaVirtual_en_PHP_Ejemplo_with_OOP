<?php

/**
 * Description of Order
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Order {
    public static function saveNewOrder($userId, $username, $userphone,
            $usercomment, $productsInCart){
        $db = Db::getConnection();
        $query = "INSERT INTO `order` (`date_created`, `user_id`, `username`,"
                . " `userphone`, `comment`, `total`)"
                . " VALUES(NOW(), :user_id, :username, :userphone,"
                . ":comment, :total);";
        $statement = $db->prepare($query);
        $userId = $userId ? $userId : 0;
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':userphone', $userphone, PDO::PARAM_STR);
        $statement->bindParam(':comment', $usercomment, PDO::PARAM_STR);
        $cartTotalSum = Cart::calculateTotalSum();
        $statement->bindParam(':total', $cartTotalSum, PDO::PARAM_INT);
        
        $orderSaved = $statement->execute();
        $allOrderItemsSaved = true;
        $allStocksUpdated = true;
        if($orderSaved){
            $orderId = $db->lastInsertId();
            foreach($productsInCart as $productId => $productCount){
                if(!OrderItem::createNew($orderId, $productId, $productCount)){
                    $allOrderItemsSaved = false;
                    break;
                }
                $currStock = Product::getProductStock($productId);
                $newStock = $currStock - $productCount;
                if(!Product::updateProductStock($productId, $newStock)){
                    $allStocksUpdated = false;
                    break;
                }
            }
        }
        return $orderSaved && $allOrderItemsSaved;
    }
    
    public static function getAll(){
       $db = Db::getConnection();
       $query = "SELECT * FROM `order`"; 
       $statement = $db->prepare($query);
       if($statement->execute()){
           return $statement->fetch(PDO::FETCH_ASSOC);
       }
       return false;
    }
    
    public static function getUserOrders($userId){
       $db = Db::getConnection();
       $query = "SELECT o.* FROM `order` AS o WHERE o.user_id = :user_id"; 
       $statement = $db->prepare($query);
       $statement->bindParam(':user_id', $userId);
       if($statement->execute()){
           return $statement->fetchAll(PDO::FETCH_ASSOC);
       }
       return false;
    }
}
