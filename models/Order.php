<?php

/**
 * Description of Order
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Order {
    
    const SHOW_BY_DEFAULT = 12;
    
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
    
    public static function update($options){
        $db = Db::getConnection();
        $query = "UPDATE `order` SET `date_payment` = :date_payment,"
                . " `username` = :username, `userphone` = :userphone,"
                . " `comment` = :comment, `status` = :status"
                . " WHERE `id` = :id LIMIT 1";
        $statment = $db->prepare($query);
        $statment->bindParam(':date_payment', $options['date_payment']);
        $statment->bindParam(':username', $options['username']);
        $statment->bindParam(':userphone', $options['userphone']);
        $statment->bindParam(':comment', $options['comment']);
        $statment->bindParam(':status', $options['status']);
        $statment->bindParam(':id', $options['id']);
        return $statment->execute();
    }
    
    public static function getAll(){
       $db = Db::getConnection();
       $query = "SELECT * FROM `order`"; 
       $statement = $db->prepare($query);
       if($statement->execute()){
           return $statement->fetchAll(PDO::FETCH_ASSOC);
       }
       return false;
    }
    
    public static function getById($orderId){
        $db = Db::getConnection();
        $query = "SELECT * FROM `order` WHERE `id` = :id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $orderId);
        if($statement->execute()){
           return $statement->fetch(PDO::FETCH_ASSOC);
       }
       return false;
    }
    
    public static function getForPage($page = 1){
       $db = Db::getConnection();
       $query = "SELECT * FROM `order` ORDER BY `id` DESC LIMIT :lim OFFSET :offset"; 
       $lim = self::SHOW_BY_DEFAULT;
       $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
       $statement = $db->prepare($query);
       $statement->bindParam(':lim', $lim, PDO::PARAM_INT);
       $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
       if($statement->execute()){
           return $statement->fetchAll(PDO::FETCH_ASSOC);
       }
       return $statement->errorInfo();
    }
    
    public static function countAll(){
        $db = Db::getConnection();
        $query = "SELECT COUNT(`id`) AS total FROM `order`";
        $statement = $db->prepare($query);
        if($statement->execute()){
            $res = $statement->fetch(PDO::FETCH_ASSOC);
            return $res['total'];
        }
        return 0;
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
    
    public static function removeById($orderId){
        $db = Db::getConnection();
        $query = "DELETE FROM `order` WHERE `id` = :id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $orderId, PDO::PARAM_INT);
        return $statement->execute();
    }
    
    public static function getStatusDescription($statusCode){
        return OrderStatus[intval($statusCode)];
    }
}
