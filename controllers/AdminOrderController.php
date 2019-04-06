<?php

/**
 * Description of AdminOrderController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class AdminOrderController extends AdminBase{
    public function actionIndex(){
        self::checkIfAdmin();
        require_once ROOT . '/views/admin/order/index.php';
        return true;
    }
}
