<?php

/**
 * Description of Product
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Product {
    const SHOW_BY_DEFAULT = 3;
    const SHOW_BY_DEFAULT_FOR_ADMIN = 8;
    const SHOW_RECOMMENDED = 6;
    
    public static function countAll(){
        $db = Db::getConnection();
        $query = "SELECT COUNT(`id`) AS total FROM `product`";
        $statement = $db->prepare($query);
        if($statement->execute()){
            $res = $statement->fetch(PDO::FETCH_ASSOC);
            return $res['total'];
        }
        return 0;
    }
    
    public static function countByName($searchPattern){
        $db = Db::getConnection();
        $query = "SELECT COUNT(`id`) AS total FROM `product` WHERE `name` LIKE :pattern";
        $statement = $db->prepare($query);
        $searchPattern = '%'.$searchPattern.'%';
        $statement->bindParam(':pattern', $searchPattern, PDO::PARAM_STR);
        if($statement->execute()){
            $res = $statement->fetch(PDO::FETCH_ASSOC);
            return $res['total'];
        }
        return 0;
    }
    
    public static function getAll(){
        $db = Db::getConnection();
        $query = "SELECT * FROM `product` ORDER BY `id` DESC";
        $statement = $db->prepare($query);
        if($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
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
    
    public static function getRecommended($numToShow = self::SHOW_RECOMMENDED){
        $db = Db::getConnection();
        $numToShow = intval($numToShow);
        $query = "SELECT * FROM `product` WHERE `status` = 1 AND"
                . " `is_recommended` = 1 ORDER BY `id` DESC LIMIT :to_show";
        $statement = $db->prepare($query);
        $statement->bindParam(':to_show', $numToShow, PDO::PARAM_INT);
        $res = $statement->execute();
        if($res){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    public static function getProductsByCategoryId($categoryId, $page = 1,
            $searchPattern = '', $sortCriteria = '`id` DESC'){
        $db = Db::getConnection();
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        $statement = $db->prepare("SELECT `id`, `name`, `price`, `image`, `is_new` "
                . "FROM `product` WHERE `status` = 1 AND `category_id` = :category_id"
                . " AND (`name` LIKE :search_pattern"
                . " OR `brand` LIKE :search_pattern) ORDER BY :sort_criteria"
                . " LIMIT :lim OFFSET :offset");
        $lim = self::SHOW_BY_DEFAULT;
        $statement->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $searchPattern = '%'.$searchPattern.'%';
        $statement->bindParam(':search_pattern', $searchPattern, PDO::PARAM_STR);
        $statement->bindParam(':sort_criteria', $sortCriteria, PDO::PARAM_STR);
        $statement->bindParam(':lim', $lim, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        if($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }        
        return $false;
    }
    
    public static function getProductsForPage($page = 1, $searchPattern = '',
            $sortCriteria = '`id` DESC'){
        $db = Db::getConnection();
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT_FOR_ADMIN;
        $statement = $db->prepare("SELECT * FROM `product` WHERE `status` = 1 "
                . " AND (`name` LIKE :search_pattern"
                . " OR `brand` LIKE :search_pattern) "
                . "ORDER BY :sort_criteria LIMIT :lim OFFSET :offset");
        $lim = self::SHOW_BY_DEFAULT_FOR_ADMIN;
        $searchPattern = '%'.$searchPattern.'%';
        $statement->bindParam(':search_pattern', $searchPattern, PDO::PARAM_STR);
        $statement->bindParam(':sort_criteria', $sortCriteria, PDO::PARAM_STR);
        $statement->bindParam(':lim', $lim, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
       if($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }        
        return false;
    }
    
    public static function fetchByName($searchPattern = '', $sortCriteria = '`id` DESC'){
        $db = Db::getConnection();
        $statement = $db->prepare("SELECT * FROM `product` WHERE `status` = 1 "
                . " AND (`name` LIKE :search_pattern"
                . " OR `brand` LIKE :search_pattern) "
                . "ORDER BY :sort_criteria");
        $lim = self::SHOW_BY_DEFAULT_FOR_ADMIN;
        $searchPattern = '%'.$searchPattern.'%';
        $statement->bindParam(':search_pattern', $searchPattern, PDO::PARAM_STR);
        $statement->bindParam(':sort_criteria', $sortCriteria, PDO::PARAM_STR);
        if($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }        
        return false;
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
    
    public static function getProductsByIds($ids){
        //Utils::debug($ids);
        $db = Db::getConnection();
        //Utils::debug($ids);
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $query = "SELECT * FROM `product` WHERE `id` IN ({$placeholders}) AND `status` = 1";
        $statement = $db->prepare($query);
        //$statement->bindParam(':ids', $ids, PDO::PARAM_STR);
        if($statement->execute($ids)){
            $res = $statement->fetchAll(PDO::FETCH_ASSOC);
            //Utils::debug($res);
            return $res;
        }
        return false;
    }
    
    public static function getProductStock($productId){
        $db = Db::getConnection();
        $query = "SELECT `available` AS stock FROM `product` WHERE `status` = 1 "
                . "AND `id` = :id LIMIT 1;";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $productId, PDO::PARAM_INT);
        if($statement->execute()){
            $res = $statement->fetch(PDO::FETCH_ASSOC);
            return $res['stock'];
        }
        return 0;
    }
    
    public static function updateProductStock($productId, $newStock){
        $db = Db::getConnection();
        $query = "UPDATE `product` SET `available` = :stock WHERE `id` = :id LIMIT 1;";
        $statement = $db->prepare($query);
        $newStock = intval($newStock);
        if($newStock < 0){
            $newStock = 0;
        }
        $statement->bindParam(':stock', $newStock, PDO::PARAM_INT);
        $statement->bindParam(':id', $productId);
        return $statement->execute();
    }
    
    public static function addNew($options){
        $db = Db::getConnection();
        $query = "INSERT INTO `product` (`name`, `code`, `category_id`, `price`,"
                . "`available`, `brand`, `description`, `is_recommended`,"
                . "`status`, `is_new`) VALUES(:name, :code, :category_id, :price,"
                . ":available, :brand, :description, :is_recommended, :status,"
                . ":is_new);";
        $statement = $db->prepare($query);
        $statement->bindParam(':name', $options['productName']);
        $statement->bindParam(':code', $options['productCode']);
        $statement->bindParam(':category_id', $options['productCategoryId']);
        $statement->bindParam(':price', $options['productPrice']);
        $statement->bindParam(':available', $options['productStock']);
        $statement->bindParam(':brand', $options['productBrand']);
        $statement->bindParam(':description', $options['productDescription']);
        $statement->bindParam(':is_recommended', $options['isProductRecommended']);
        $statement->bindParam(':status', $options['productStatus']);
        $statement->bindParam(':is_new', $options['isProductNew']);
        if($statement->execute()){
            return $db->lastInsertId();
        } 
        Utils::debug($statement->errorInfo());
        return false;
    }
    
    public static function update($options){
        $db = Db::getConnection();
        $query = "UPDATE `product` SET `name` = :name, `code` = :code,"
                . " `category_id` = :category_id, `price` = :price,"
                . "`available` = :available, `brand` = :brand,"
                . " `description` = :description,"
                . " `is_recommended` = :is_recommended,"
                . "`status` = :status, `is_new` = :is_new WHERE `id` = :id"
                . " LIMIT 1;";
        $statement = $db->prepare($query);
        $statement->bindParam(':name', $options['productName']);
        $statement->bindParam(':code', $options['productCode']);
        $statement->bindParam(':category_id', $options['productCategoryId']);
        $statement->bindParam(':price', $options['productPrice']);
        $statement->bindParam(':available', $options['productStock']);
        $statement->bindParam(':brand', $options['productBrand']);
        $statement->bindParam(':description', $options['productDescription']);
        $statement->bindParam(':is_recommended', $options['isProductRecommended']);
        $statement->bindParam(':status', $options['productStatus']);
        $statement->bindParam(':is_new', $options['isProductNew']);
        $statement->bindParam(':id', $options['id']);
        if($statement->execute()){
            return true;
        } 
        Utils::debug($statement->errorInfo());
        return false;
    }
    
    public static function updateImage($productId, $image){
        $db = Db::getConnection();
        $query = "UPDATE `product` SET `image` = :image"
                . " WHERE `id` = :id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindParam(':image', $image);
        $statement->bindParam(':id', $productId);
        return $statement->execute();
    }
    
    public static function removeById($productId){
        $db = Db::getConnection();
        $query = "DELETE FROM `product` WHERE `id` = :id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $productId, PDO::PARAM_INT);
        $res = $statement->execute();
        //Utils::debug($statement->errorInfo());
        return $res;
    }
    
    public static function getImage($productId){
        $product = self::getProductById($productId);
        $root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
        //Utils::debug($root);
        if(!$product || !$product['image']){
            return PathToProductImages.NoImage;
        }
        $pathToImage = ROOT.PathToProductImages.$product['image'];
        //echo $pathToImage;
        if(file_exists($pathToImage)){
            return PathToProductImages.$product['image'];
        } else {
            return PathToProductImages.NoImage;
        }
    }
    
}
