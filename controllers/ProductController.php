<?php

/**
 * Description of ProductController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */

class ProductController {
    public function actionView($productId){
        $categories = Category::getAll();
        $product = Product::getProductById($productId);
        require_once(ROOT. "/views/product/view.php");
        return true;
    }
}
