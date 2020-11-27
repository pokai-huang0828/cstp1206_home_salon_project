<?php 

class SignInService{ 

    // check user email and password, if match, return userID
    public static function checkEmailAndPassword($email, $password){
        
        $email = trim(strtolower($email));
        $password = trim(strtolower($password));
        
        UserDAO::init();
        $stdUser = UserDAO::getUserByEmailAndPassword($email, $password);

        return $stdUser;

    }





}


?>