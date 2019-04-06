<?php

/**
 * Description of AdminBase
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class AdminBase {
    
    public static function checkIfAdmin(){
        $loggedUserId = User::checkIfLogged();
        $isAdmin = User::checkIfAdmin($loggedUserId);
        
        if(!$isAdmin){
            die("Permission denied");
        }
    }
}
