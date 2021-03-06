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
        //Utils::debug($encryptedPassword);
        $statement->bindParam(':password', $encryptedPassword, PDO::PARAM_STR);
        if($statement->execute()){
            $res = $statement->fetch();
            return $res['id'];
        }

        return false;
    }
    
    public static function checkPhone($phone){
        $pattern = "~([+38]?)0((50)|(63)|(66)|(67)|(68)|(93)|(95)|(96)|(97)|(99)|(99))([0-9]{6})~";
        return preg_match($pattern, $phone);
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
    
    public static function update($userId, $name, $password = null){
        $db = Db::getConnection();
        $query = "UPDATE `user` SET `name` = :name ";
        
        if($password != null){
            $query .= " , `password` = :password ";
        }
        
        $query .= " WHERE `id` = :id LIMIT 1;";
        
        //Utils::debug($query);                
        
        $statement = $db->prepare($query);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        
        if($password != null){
            $encryptedPassword = md5($password);
            $statement->bindParam(':password', $encryptedPassword, PDO::PARAM_STR);
        }
        
        $statement->bindParam(':id', $userId, PDO::PARAM_INT);
        return $statement->execute();
    }
    
    public static function removeById($userId){
        $db = Db::getConnection();
        $query = "DELETE * FROM `user` WHERE id = :id LIMIT 1;";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $userId);
        return $statement->execute();
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
    
    public static function getLoggedUserId(){
        return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
    }
    
    public static function isGuest(){
        return !isset($_SESSION['user']);
    }
    
    public static function getUserRoles($userId){
        $db = Db::getConnection();
        $query = "SELECT u.id, u.name, ur.role_id, r.name FROM `user_role` AS ur"
                . " LEFT JOIN `role` AS r ON ur.role_id = r.id"
                . " LEFT JOIN `user` AS u ON ur.user_id = u.id"
                . " WHERE u.id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        if($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    public static function checkIfAdmin($userId){
        $db = Db::getConnection();
        $query = "SELECT ur.role_id, r.name FROM `user_role` AS ur"
                . " LEFT JOIN `role` AS r ON ur.role_id = r.id"
                . " LEFT JOIN `user` AS u ON ur.user_id = u.id"
                . " WHERE r.id = 2 AND r.name = 'admin' AND u.id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        if($statement->execute()){
            $userRole = $statement->fetch(PDO::FETCH_ASSOC);
            return $userRole['role_id'] == 2 && $userRole['name'] == 'admin';
        }
        return false;
    }
    
    public static function getAllAdmins(){
        $db = Db::getConnection();
        $query = "SELECT u.* FROM `user_role` AS ur"
                . " LEFT JOIN `role` AS r ON ur.role_id = r.id"
                . " LEFT JOIN `user` AS u ON ur.user_id = u.id"
                . " WHERE r.id = 2 AND r.name = 'admin'";
        $statement = $db->prepare($query);
        if($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
}


