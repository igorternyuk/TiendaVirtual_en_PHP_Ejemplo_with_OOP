<?php

/**
 * Description of CabinetController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class CabinetController {
    
    public function actionIndex(){
        $userId = User::checkIfLogged();
        $user = User::getById($userId);
        if($userId){
            
            require_once ROOT . '/views/cabinet/index.php';
            
        }
        return true;
    }
}
