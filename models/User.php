<?php

/**
 * Description of User
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class User {
    const USERNAME_LENGTH_MIN = 3;
    const PASSWORD_LENGTH_MIN = 6;
    
    public static function checkUsername($username){
        return strlen($username) >= self::USERNAME_LENGTH_MIN;
    }
    
    public static function checkEmail($email){
        
        //Utils::debug(['email' => $email, 'valid' => filter_var($email, FILTER_VALIDATE_EMAIL)]);
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }
    
    public static function checkPassword($password){
        return strlen($password) >= self::PASSWORD_LENGTH_MIN;
    }
    
    public static function checkPasswordMatch($pwd1, $pwd2){
        return strcmp($pwd1, $pwd2) == 0;
    }
    
    public static function checkIfEmailExists($email){
        $db = Db::getConnection();
        $query = "SELECT COUNT(*) FROM `user` WHERE `email` = :email";
        $statement = $db->prepare($query);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        //Utils::debug($statement->fetchColumn());
        return $statement->fetchColumn() ? true : false;
    }
    
    public static function checkUserCredentials($email, $password){
        $db = Db::getConnection();
        
        $query = "SELECT `id` FROM `user` WHERE `email` = :email"
                . " AND `password` = :password;";
        $statement = $db->prepare($query);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $encryptedPassword = md5($password);
        $statement->bindParam(':password', $encryptedPassword, PDO::PARAM_STR);
        if($statement->execute()){
            $res = $statement->fetch();
            return $res['id'];
        }
        return false;
        
    }
    
    public static function register($username, $email, $password){
        $encryptedPassword = md5($password);
        $db = Db::getConnection();
        $query = "INSERT INTO `user` (`name`, `email`, `password`) VALUES(:username,"
                . " :email, :password)";
        //Utils::debug($query);
        $statement = $db->prepare($query);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $encryptedPassword, PDO::PARAM_STR);
        $userAdded = $statement->execute();
        $user_id = $db->lastInsertId();
        $query = "INSERT INTO `user_role` (`user_id`, `role_id`) VALUES(:user_id,"
                . " '1')";
        $statement = $db->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $roleAdded = $statement->execute();
        return $userAdded && $roleAdded;
    }
    
    public static function getById($userId){
        $db = Db::getConnection();
        $query = "SELECT * FROM `user` WHERE `id` = :id LIMIT 1;";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $userId);
        if($statement->execute()){
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            return $user;
        }
        return false;
    }
    
    public static function login($userId){
        $_SESSION['user'] = $userId;
    }
    
    public static function checkIfLogged(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
        
        Utils::redirect("/user/login");
    }
    
    public static function isGuest(){
        return isset($_SESSION['user']);
    }
}

/*
CREATE TABLE `user`(
	`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL
);

CREATE TABLE `role`(
	`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL
);

CREATE TABLE `user_role`(
	`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `role_id` INT NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`),
    FOREIGN KEY (`role_id`) REFERENCES `role`(`id`)
);
 *  */
