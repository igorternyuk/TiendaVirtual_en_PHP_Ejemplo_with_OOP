<?php

/**
 * Description of UserController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class UserController {
    //put your code here
    public function actionRegister(){
        $username = '';
        $email = '';
        $pwd1 = '';
        $pwd2 = '';
        $btnRegister = filter_input(INPUT_POST, 'btnRegister');
        $registered = false;
        if(isset($btnRegister)){
            $errors = [];
            
            $username = filter_input(INPUT_POST, 'username');
            if(!User::checkUsername($username)){
                array_push($errors, "Имя не должно быть короче 3-х символов");
            }
            
            $email = filter_input(INPUT_POST, 'email');
            if(!User::checkEmail($email)){
                array_push($errors, "Некорректный E-mail");
            }
            
            $pwd1 = filter_input(INPUT_POST, 'pwd1');
            if(!User::checkPassword($pwd1)){
                array_push($errors, "Пароль дожен быть не короче 6-ти символов");
            }
            
            $pwd2 = filter_input(INPUT_POST, 'pwd2');
            if(!User::checkPasswordMatch($pwd1, $pwd2)){
                array_push($errors, "Пароли не совпадают");
            }
            
            if(User::checkIfEmailExists($email)){
                array_push($errors, "E-mail уже зарегистрирован");
            }
            
            if(count($errors) == 0){
                $registered = User::register($username, $email, $pwd1);
            }
            
        }
        /*Utils::debug(['username' => $username, 'email' => $email,
            'pwd1' => $pwd1, 'pwd2' => $pwd2]);*/
        require_once ROOT . '/views/user/register.php';
        return true;
    }
}
