<?php

/**
 * Description of SiteController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */

include_once ROOT."/models/Category.php";
include_once ROOT."/models/Product.php";

class SiteController {
    public function actionIndex(){
        $categories = Category::getAll();
        $products = Product::getLatest();
        //Utils::debug($products);
        require_once(ROOT . "/views/site/index.php");
        return true;
    }
}
