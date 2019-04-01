<?php

/**
 * Description of ProductController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class ProductController {
    public function actionView($id){
        require_once(ROOT. "/views/product/view.php");
        return true;
    }
}
