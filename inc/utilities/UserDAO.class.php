<?php 

class UserDAO{

    private static $_db; 

    public static function init(){
        self::$_db = new PDOService("User");
    }
    
    public static function getUserByEmail($email){

        $email = trim(strtolower($email));

        $sql = "SELECT * From users
                WHERE email = :email";

        self::$_db->query($sql);
        self::$_db->bind(":email", $id);

        try{
            self::$_db->execute();
            $result = self::$_db->singleResult();
            return self::convertToStdClass($result);

        } catch(PDOException $e){
            return self::returnError($e);

        }

    }

    public static function getUserByEmailAndPassword($email, $password){

        $sql = "SELECT * From users
                WHERE email = :email AND password = :password";

        self::$_db->query($sql);
        self::$_db->bind(":email", $email);
        self::$_db->bind(":password", $password);

        try{

            self::$_db->execute();
            $result = self::$_db->singleResult();

            if($result){
                return self::convertToStdClass($result);
            } else {
                throw new Exception("Invalid Credential");
            }

        } catch(Exception $e){
            return self::returnError($e);

        }

    }

    private static function convertToStdClass($results){

        $s = new StdClass;
        $s = self::copyPropertiesOver($results, $s);
        return $s;

    }

    private static function copyPropertiesOver($user, $std_user){
        
        // User info
        $std_user->userID = $user->getUserID();
        // $std_user->password = $user->getPassword();
        $std_user->role = $user->getRole();
        $std_user->firstName = $user->getFirstName();
        $std_user->lastName = $user->getLastName();
        $std_user->profilePic = $user->getProfilePic();
        $std_user->signUpDate = $user->getSignUpDate();
        $std_user->gender = $user->getGender();
        $std_user->phoneNumber = $user->getPhoneNumber();
        $std_user->email = $user->getEmail();

        return $std_user;

    }

    private static function returnError($e){
        $error = new StdClass;
        $error->error = $e->getMessage();
        return $error;
    }


}

?>