<?php 

class SignInService{

    // check user email and password, if match, return userID
    public static function checkEmailAndPassword($email, $password){

        $email = trim(strtolower($email));
        $password = trim(strtolower($password));
        
        UserDAO::init();

        $stdUser = UserDAO::getUserByEmailAndPassword($email, $password);

        if(!isset($stdUser)){
            $stdUser = new stdClass;
            $stdUser->error = "Invalid email or password.";
            return $stdUser;
        } 

        return $stdUser;

    }





}


?>