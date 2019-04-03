<?php

/**
 * Description of CatalogController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */

class CatalogController {
   
   public function actionIndex(){
        $categories = Category::getAll();
        foreach($categories as &$category){
            $category['total'] = Product::countProductsOfCategory($category['id']);
        }
        $products = Product::getLatest();

        require_once(ROOT . '/views/catalog/index.php');
        return true;
   }
   
   public function actionCategory($categoryId, $page = 1){
       //Utils::debug(['categoryId' => $categoryId, 'page' => $page]);
       $categories = Category::getAll();
       foreach($categories as &$category){
            $category['total'] = Product::countProductsOfCategory($category['id']);;
        }
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
