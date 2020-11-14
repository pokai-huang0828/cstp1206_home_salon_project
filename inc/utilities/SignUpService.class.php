<?php 

class SignUpService {

    // List of Stylists
    private static $stylists = array();
    private static $users = array();

    private static $user;
    private static $stylist;

    static function refreshLists(){
        
        $stylist_data_path = realpath("../../data/stylist.data.csv");
        $user_data_path = realpath("../../data/user.data.csv");

        $stylist_content = FileService::readfile($stylist_data_path);
        self::$stylists = StylistParser::parseStylists($stylist_content);

        $user_content = FileService::readfile($user_data_path);
        self::$users = UserParser::parseUser($user_content);

    }

    public static function signUp($userInputs){

        self::refreshLists();
        self::$user = $userInputs;

        // check if userInputs->email already exist 
        if(self::isEmailAlreadyExist($userInputs->email)){

            // return the userInputs + Error
            $userInputs->error = "Email already existed in system: ".$userInputs->email;
            return $userInputs;
        };

        switch (self::$user->role){
            
            case "stylist":
                // sign up a stylist user
                self::createUser();
                self::createStylistProfile();

                // append user and stylist to the lists
                SignUpService::$users[] = self::$user;
                SignUpService::$stylists[] = self::$stylist;
                
                // stringify users and stylists
                $users_str = SignUpService::stringifyUsers(self::$users);
                $stylists_str = SignUpService::stringifyStylists(self::$stylists);
                
                // paths to the csv files
                $stylist_data_path = realpath("../../data/stylist.data.csv");
                $user_data_path = realpath("../../data/user.data.csv");
                
                // write to file
                SignUpService::saveStrToFile($user_data_path, $users_str);
                SignUpService::saveStrToFile($stylist_data_path, $stylists_str);

                return self::createStdClassUser();

            break;

            case "customer":
                // sign up a customer user
            break;
        }

    }

    private static function createStdClassUser(){

        $stdUser = new stdClass();

        $stdUser->userID = self::$user->getUserID();
        $stdUser->email = self::$user->getEmail();
        $stdUser->firstName = self::$user->getFirstName();
        $stdUser->lastName = self::$user->getLastName();
        $stdUser->gender = self::$user->getGender();
        $stdUser->phoneNumber = self::$user->getPhoneNumber();
        $stdUser->role = self::$user->getRole();

        return $stdUser;

    }

    private static function isEmailAlreadyExist($emailInput){

        foreach (self::$users as $user){
            if(strtolower($user->getEmail()) == $emailInput) return true;
        }
        return false;

    }

    private static function saveStrToFile($filename, $fileContent){
        FileService::writeFile($filename, $fileContent);
    }

    private static function stringifyUsers($users){

        // convert each user into string
        $user_str = "userID,password,role,firstName,lastName,profilePic,signUpDate,gender,phoneNumber,email";

        foreach(self::$users as $u){
            $user_str .= "\n".
            $u->getUserID().",".
            $u->getPassword().",".
            $u->getRole().",".
            $u->getFirstName().",".
            $u->getLastName().",".
            $u->getProfilePic().",".
            $u->getSignUpDate().",".
            $u->getGender().",".
            $u->getPhoneNumber().",".
            $u->getEmail();
        }

        return $user_str;
    }

    private static function stringifyStylists($stylist){

        // convert each stylist into string
        $stylist_str = "userID,professionalExperience,rating,serviceLocation,category,priceList,portfolio";

        foreach(self::$stylists as $s){
            $stylist_str .= "\n".
            $s->getUserID().",".
            $s->getProfessionalExperience().",".
            $s->getRating().",".
            $s->getServiceLocation().",".
            $s->getCategory().",".
            $s->getPriceList().",".
            $s->getPortfolio();
        }

        return $stylist_str;
    }

    private static function createUser(){

        $user_obj = new User();

        //create userID
        $userID = SignUpService::generateRandomString();

        // set user
        $user_obj->setUserID($userID);
        $user_obj->setSignUpDate(date("Y-m-d"));
        $user_obj->setPassword(self::$user->password);
        $user_obj->setRole(self::$user->role);
        $user_obj->setFirstName(self::$user->firstName);
        $user_obj->setLastName(self::$user->lastName);
        $user_obj->setGender(strtolower(self::$user->gender));
        $user_obj->setPhoneNumber(self::$user->phoneNumber);
        $user_obj->setEmail(strtolower(self::$user->email));

        self::$user = $user_obj;
    }

    private static function createStylistProfile(){
        
        $s_pro = new Stylist();
        $s_pro->setUserID(self::$user->getUserID());
        self::$stylist = $s_pro;

    }

    private static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}



?>