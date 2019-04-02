<?php

/**
 * Description of CatalogController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */

include_once ROOT."/models/Category.php";
include_once ROOT."/models/Product.php";

class CatalogController {
   
   public static function actionIndex(){
        $categories = Category::getAll();
        $products = Product::getLatest();
        require_once(ROOT . '/views/catalog/index.php');
        return true;
   }
   
   public static function actionCategory($categoryId){
       $categories = Category::getAll();
       $products = Product::getProductsByCategoryId($categoryId);
       //Utils::debug($products);
       require_once(ROOT . '/views/catalog/category.php');
       return true;
   }
   
}
