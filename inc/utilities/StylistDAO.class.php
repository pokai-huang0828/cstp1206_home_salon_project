<?php  

class StylistDAO { 

    private static $_db;

    public static function init(){
        self::$_db = new PDOService("Stylist");
    }
    
    public static function getStylists(){

        $sql = "SELECT * FROM users
                JOIN stylists USING(userID);";

        //Query
        self::$_db->query($sql);

        //Exec
        self::$_db->execute();

        // Results
        $results = self::$_db->resultSet();

        // Return 
        return self::convertStylistsToStdClass($results);

    }
    
    public static function getStylistById($id){

        $sql = "SELECT * From users
                JOIN stylists USING(userID)
                WHERE userID = :id";

        self::$_db->query($sql);
        self::$_db->bind(":id", $id);

        try{

            self::$_db->execute();
            $result = self::$_db->singleResult();

            if($result){
                return self::convertStylistsToStdClass($result);
            }else {
                $error = new stdClass;
                $error->error = "No stylist with this id.";
                return $error;
            }

        }catch (Exception $e){
            return self::returnError($e);
        }

    }

    public static function updateStylists($profile){

        $sql = "
        START TRANSACTION;

        UPDATE stylists
        SET 
        professionalExperience = :professionalExperience,
        rating = :rating,
        serviceLocation = :serviceLocation,
        category = :category,
        priceList = :priceList,
        portfolio = :portfolio
        WHERE userID = :userID;

        UPDATE users
        SET
        password = :password,
        role = :role,
        firstName = :firstName,
        lastName = :lastName,
        profilePic = :profilePic,
        gender = :gender,
        phoneNumber = :phoneNumber,
        email = :email
        WHERE userID = :userID;

        COMMIT;";

        self::$_db->query($sql);

        self::$_db->bind(":userID", $profile->userID);
        self::$_db->bind(":firstName", $profile->firstName);
        self::$_db->bind(":lastName", $profile->lastName);
        self::$_db->bind(":password", $profile->password);
        self::$_db->bind(":phoneNumber", $profile->phoneNumber);
        self::$_db->bind(":email", $profile->email);
        self::$_db->bind(":gender", $profile->gender);
        self::$_db->bind(":profilePic", $profile->profilePic);

        self::$_db->bind(":professionalExperience", $profile->professionalExperience);
        self::$_db->bind(":rating", 5);
        self::$_db->bind(":category", $profile->category);
        self::$_db->bind(":serviceLocation", $profile->serviceLocation);
        self::$_db->bind(":priceList", $profile->priceList);
        self::$_db->bind(":portfolio", $profile->portfolio);
        self::$_db->bind(":role", $profile->role);

        try{
            self::$_db->execute();
            return $profile;

        } catch(PDOException $e){
            return self::returnError($e);
        }

    }

    public static function addStylist($user){

        // first add record to user, then retrive id
        $sql = "
        INSERT INTO users
        (password, role, firstName, lastName, 
         signUpDate, gender, 
        phoneNumber, email)
        VALUES
        (:password, :role, :firstName, :lastName, 
        :signUpDate, :gender, 
        :phoneNumber, :email);
        ";

        self::$_db->query($sql);

        self::$_db->bind(":password", $user->getPassword());
        self::$_db->bind(":role", $user->getRole());
        self::$_db->bind(":firstName", $user->getFirstName());
        self::$_db->bind(":lastName", $user->getLastName());
        // self::$_db->bind(":profilePic", " ");
        self::$_db->bind(":signUpDate", $user->getSignUpDate());
        self::$_db->bind(":gender", $user->getGender());
        self::$_db->bind(":phoneNumber", $user->getPhoneNumber());
        self::$_db->bind(":email", $user->getEmail());

        try{

            self::$_db->execute();

            // return userID 
            $userID = self::$_db->lastInsertKey();

            // create stylist record
            $sql = 'INSERT INTO stylists(userID) 
                    values (:userID);';

            self::$_db->query($sql);

            self::$_db->bind(":userID", $userID);

            self::$_db->execute();

            // set the userID the user obj and return 
            $user->setUserID($userID);

            // var_dump($user);

            return self::convertUserToStdClass($user);

        } catch (Exception $e){
            if($e->getCode() == '23000') {
                $error = new stdClass;
                $error->error = "This email has been registered.";
                return $error;
            } else{
                return self::returnError($e);
            }
        }

    }

    private static function convertStylistsToStdClass($results){

        if(is_array($results)){
            $std_stylists = array();

            foreach($results as $stylist){
                $s = new StdClass;
    
                self::copyStylistPropertiesOver($stylist, $s);
    
                $std_stylists[] = $s;
            }

            return $std_stylists;

        } else{

            $s = new StdClass;
            self::copyStylistPropertiesOver($results, $s);
            return $s;

        }

    }

    private static function copyStylistPropertiesOver($stylist, $std_stylist){
        
        // User info
        $std_stylist->userID = $stylist->getUserID();
        $std_stylist->password = $stylist->getPassword();
        $std_stylist->role = $stylist->getRole();
        $std_stylist->firstName = $stylist->getFirstName();
        $std_stylist->lastName = $stylist->getLastName();
        $std_stylist->profilePic = $stylist->getProfilePic();
        $std_stylist->signUpDate = $stylist->getSignUpDate();
        $std_stylist->gender = $stylist->getGender();
        $std_stylist->phoneNumber = $stylist->getPhoneNumber();
        $std_stylist->email = $stylist->getEmail();

        // Stylists info
        $std_stylist->professionalExperience = $stylist->getProfessionalExperience();
        $std_stylist->rating = $stylist->getRating();
        $std_stylist->serviceLocation = $stylist->getServiceLocation();
        $std_stylist->category = $stylist->getCategory();
        $std_stylist->priceList = $stylist->getPriceList();
        $std_stylist->portfolio = $stylist->getPortfolio();

    }

    // User convert StdUser

    private static function convertUserToStdClass($result){

        $s = new StdClass;
        $s = self::copyUserPropertiesOver($result, $s);
        return $s;

    }

    private static function copyUserPropertiesOver($user, $std_user){
        
        // User info
        $std_user->userID = $user->getUserID();
        $std_user->password = $user->getPassword();
        $std_user->role = $user->getRole();
        $std_user->firstName = $user->getFirstName();
        $std_user->lastName = $user->getLastName();
        // $std_user->profilePic = $user->getProfilePic();
        $std_user->signUpDate = $user->getSignUpDate();
        $std_user->gender = $user->getGender();
        $std_user->phoneNumber = $user->getPhoneNumber();
        $std_user->email = $user->getEmail();

        return $std_user;

    }

    private static function returnError($e){
        $error = new stdClass;
        $error->error = $e->getMessage();
        return $error;
    }


}

?>