<?php

/**
 * Description of AdminCategoryController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class AdminCategoryController extends AdminBase{
    public function actionIndex(){
        self::checkIfAdmin();
        require_once ROOT . '/views/admin/category/index.php';
        return true;
    }
}
