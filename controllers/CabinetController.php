<?php

/**
 * Description of CabinetController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class CabinetController {
    
    public function actionIndex(){
        $userId = User::checkIfLogged();
        //$user = User::getById($userId);
        if($userId){
            
            require_once ROOT . '/views/cabinet/index.php';
            
        }
        return true;
    }
    
    public function actionEdit(){
        
        $userId = User::checkIfLogged();
        
        $user = User::getById($userId);
        
        $username = $user['name'];
        $email = $user['email'];
        $pwd1 = $pwd2 = $user['password'];
        $currPassword = '';
        $btnEdit = filter_input(INPUT_POST, 'btnEdit');
        
        if(isset($btnEdit)){
            $errors = [];
            
            $username = filter_input(INPUT_POST, 'username');
            if(!User::checkUsername($username)){
                array_push($errors, "Имя не должно быть короче 3-х символов");
            }
            
            $pwd1 = filter_input(INPUT_POST, 'pwd1');
            $pwd2 = filter_input(INPUT_POST, 'pwd2');
            //Utils::debug(['pwd1' => $pwd1, 'pwd2' => $pwd2]);
            if($pwd1 == ''){
                $pwd1 = null;
                //Utils::debug(['pwd1' => $pwd1]);
            } else {
                if(!User::checkPassword($pwd1)){
                    array_push($errors, "Пароль дожен быть не короче 6-ти символов");
                }
                
                if(!User::checkPasswordMatch($pwd1, $pwd2)){
                    array_push($errors, "Пароли не совпадают!");
                }
            }
            
            $currPassword = filter_input(INPUT_POST, 'currPassword');
            //Utils::debug(['currPass ' => $currPassword, 'enc' => md5($currPassword)]);
            if(!User::checkUserCredentials($email, $currPassword)){
                array_push($errors, "Текущий пароль неверный!");
            }
            
            if(count($errors) == 0){
                $res = User::update($userId, $username, $pwd1);
            }
            
        }
        /*Utils::debug(['username' => $username, 'email' => $email,
            'pwd1' => $pwd1, 'pwd2' => $pwd2]);*/
        require_once ROOT . '/views/cabinet/edit.php';
        return true;
    }
}
