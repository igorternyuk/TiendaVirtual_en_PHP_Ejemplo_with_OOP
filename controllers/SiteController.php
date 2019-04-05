<?php

/**
 * Description of SiteController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */

class SiteController {
    public function actionIndex(){
        $categories = Category::getAll();
        
        foreach($categories as &$category){
            $category['total'] = Product::countProductsOfCategory($category['id']);
        }
        //Utils::debug($categories);
        $products = Product::getLatest();
        $recommendedProducts = Product::getRecommended();
        
        //Utils::debug($recommendedProducts);
        require_once(ROOT . "/views/site/index.php");
        return true;
    }
}
