<?php

/**
 * Description of AdminController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class AdminController extends AdminBase{
   
    public function actionIndex(){
        self::checkIfAdmin();
        require_once ROOT . '/views/admin/index.php';
        return true;
    }
}
