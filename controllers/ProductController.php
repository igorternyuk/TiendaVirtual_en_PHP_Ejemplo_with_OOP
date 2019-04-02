<?php

/**
 * Description of ProductController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */

include_once ROOT.'/models/Category.php';
include_once ROOT.'/models/Product.php';

class ProductController {
    public function actionView($productId){
        $categories = Category::getAll();
        $product = Product::getProductById($productId);
        require_once(ROOT. "/views/product/view.php");
        return true;
    }
}
