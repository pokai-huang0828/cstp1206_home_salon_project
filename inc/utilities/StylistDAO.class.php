<?php 

class StylistDAO {

    // List of Stylists
    private static $stylists = array();
    private static $users = array();
    
    // Merging Stylist and User
    private static $mergedList = array();
    
    // Make a function to get an updated list of stylist from the CSV file
    static function refreshStylists(){
        
        $stylist_data_path = realpath("../../data/stylist.data.csv");
        $user_data_path = realpath("../../data/user.data.csv");

        $stylist_content = FileService::readfile($stylist_data_path);
        self::$stylists = StylistParser::parseStylists($stylist_content);

        $user_content = FileService::readfile($user_data_path);
        self::$users = UserParser::parseUser($user_content);

        // merging stylist_obj and user_obj into a std_obj
        for($i=0; $i < count(self::$stylists); $i++){

            $merged_obj = new stdClass;

            // Stylist Info
            $merged_obj->userID = self::$stylists[$i]->getUserID();
            $merged_obj->professionalExperience = self::$stylists[$i]->getProfessionalExperience();
            $merged_obj->rating = self::$stylists[$i]->getRating();
            $merged_obj->serviceLocation = self::$stylists[$i]->getServiceLocation();
            $merged_obj->category = self::$stylists[$i]->getCategory();
            $merged_obj->priceList = self::$stylists[$i]->getPriceList();
            $merged_obj->portfolio = self::$stylists[$i]->getPortfolio();

            // User Info
            $merged_obj->password = self::$users[$i]->getPassword();
            $merged_obj->lastName = self::$users[$i]->getLastName();
            $merged_obj->firstName = self::$users[$i]->getFirstName();
            $merged_obj->role = self::$users[$i]->getRole();
            $merged_obj->gender = self::$users[$i]->getGender();
            $merged_obj->phoneNumber = self::$users[$i]->getPhoneNumber();
            $merged_obj->email = self::$users[$i]->getEmail();
            $merged_obj->signUpDate = self::$users[$i]->getSignUpDate();
            $merged_obj->profilePic = self::$users[$i]->getProfilePic();

            self::$mergedList[] = $merged_obj;

        }
        
    }

    public static function getStylists(){

        self::refreshStylists();

        return StylistDAO::$mergedList;

    }
    
    public static function getStylistById($id){
        
        self::refreshStylists();
        
        foreach(self::$mergedList as $merged_obj){

            if($merged_obj->userID == $id){
                return $merged_obj;
            }
            
        }

    }

    public static function updateStylists($profile){

        StylistDAO::refreshStylists();

        // Modifying stylist data
        foreach(StylistDAO::$stylists as $stylist){
            if($stylist->getUserID() == $profile->userID){
                foreach($profile as $prop => $value){
                    if(property_exists($stylist, $prop)){
                        self::setStylistProperty($stylist, $prop, $value);
                    }
                }
            }
        }

        // Modifying user data
        foreach(StylistDAO::$users as $user){
            if($user->getUserID() == $profile->userID){
                foreach($profile as $prop => $value){
                    if(property_exists($user, $prop)){
                        self::setUserProperty($user, $prop, $value);
                    }
                }
            }
        }

        // convert each stylist into string
        $stylist_str = "userID,professionalExperience,rating,serviceLocation,category,priceList,portfolio";

        foreach(StylistDAO::$stylists as $s){
            $stylist_str .= "\n".
            $s->getUserID().",".
            $s->getProfessionalExperience().",".
            $s->getRating().",".
            $s->getServiceLocation().",".
            $s->getCategory().",".
            $s->getPriceList().",".
            $s->getPortfolio();
        }

        // convert each user into string
        $user_str = "userID,password,role,firstName,lastName,profilePic,signUpDate,gender,phoneNumber,email";

        foreach(StylistDAO::$users as $u){
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

        // paths to the csv files
        $stylist_data_path = realpath("../../data/stylist.data.csv");
        $user_data_path = realpath("../../data/user.data.csv");
        
        // save them in file
        FileService::writeFile($stylist_data_path, $stylist_str);
        FileService::writeFile($user_data_path, $user_str);

        return $profile;
    }

    private static function setStylistProperty(&$stylist, $property, $value){
        
        switch ($property){

            case "userID":
                $stylist->setUserID($value);
            break;
            case "professionalExperience":
                $stylist->setProfessionalExperience($value);
            break;
            case "userID":
                $stylist->setUserID($value);
            break;
            case "rating":
                $stylist->setRating($value);
            break;
            case "serviceLocation":
                $stylist->setServiceLocation($value);
            break;
            case "category":
                $stylist->setCategory($value);
            break;
            case "priceList":
                $stylist->setPriceList($value);
            break;
            case "portfolio":
                $stylist->setPortfolio($value);
            break;

        }

    }

    private static function setUserProperty(&$user, $property, $value){

        switch ($property){

            case "userID":
                $user->setUserID($value);
            break;
            case "password":
                $user->setPassword($value);
            break;
            case "role":
                $user->setRole($value);
            break;
            case "firstName":
                $user->setFirstName($value);
            break;
            case "lastName":
                $user->setLastName($value);
            break;
            case "profilePic":
                $user->setProfilePic($value);
            break;
            case "signUpDate":
                $user->setSignUpDate($value);
            break;
            case "gender":
                $user->setGender($value);
            break;
            case "phoneNumber":
                $user->setPhoneNumber($value);
            break;
            case "email":
                $user->setEmail($value);
            break;
        }

    }


}

?>