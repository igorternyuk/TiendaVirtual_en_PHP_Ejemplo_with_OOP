<?php

/**
 * Description of CatalogController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */

include_once ROOT."/models/Category.php";
include_once ROOT."/models/Product.php";
include_once ROOT."/components/Paginator.php";

class CatalogController {
   
   public static function actionIndex(){
        $categories = Category::getAll();
        $products = Product::getLatest();

        require_once(ROOT . '/views/catalog/index.php');
        return true;
   }
   
   public static function actionCategory($categoryId, $page = 1){
       //Utils::debug(['categoryId' => $categoryId, 'page' => $page]);
       $categories = Category::getAll();
       $products = Product::getProductsByCategoryId($categoryId, $page);
       $productTotal = Product::countProductsOfCategory($categoryId);
       //Utils::debug($products);
       $paginator = new Paginator($page, $productTotal, Product::SHOW_BY_DEFAULT, "page-");
       $pagination = $paginator->getHtml();
       //Utils::debug($pagination);
       require_once(ROOT . '/views/catalog/category.php');
       return true;
   }
   
}
