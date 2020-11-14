<?php 

class SignInService{

    private static $users = array();
    private static $user;

    static function refreshLists(){

        $user_data_path = realpath("../../data/user.data.csv");
        $user_content = FileService::readfile($user_data_path);
        self::$users = UserParser::parseUser($user_content);
        
    }

    // check user email and password, if match, return userID
    public static function checkEmailAndPassword($email, $password){
        
        self::refreshLists();

        foreach(self::$users as $user){
            
            if(trim($user->getEmail()) == trim(strtolower($email)) && trim($user->getPassword()) == trim($password)){
                
                self::$user = $user;

                $stdUser = new stdClass;

                $stdUser->userID = self::$user->getUserID();
                $stdUser->email = self::$user->getEmail();
                $stdUser->firstName = self::$user->getFirstName();
                $stdUser->lastName = self::$user->getLastName();
                $stdUser->gender = self::$user->getGender();
                $stdUser->phoneNumber = self::$user->getPhoneNumber();
                $stdUser->role = self::$user->getRole();
                
            }

        }

        if(!isset($stdUser)){
            $stdUser = new stdClass;
            $stdUser->error = "Invalid email or password.";
            return $stdUser;
        } 

        return $stdUser;

    }





}


?>