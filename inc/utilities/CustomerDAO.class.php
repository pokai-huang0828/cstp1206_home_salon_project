<?php  

class CustomerDAO {

    private static $_db;

    public static function init(){
        self::$_db = new PDOService("Customer");
    }
    
    public static function getCustomers(){

        $sql = "SELECT * FROM users
                JOIN customers USING(userID);";

        //Query
        self::$_db->query($sql);

        //Exec
        self::$_db->execute();

        // Results
        $results = self::$_db->resultSet();

        // Return 
        return self::convertCustomersToStdClass($results);

    }
    
    public static function getCustomerById($id){

        $sql = "SELECT * From users
                JOIN customers USING(userID)
                WHERE userID = :id";

        self::$_db->query($sql);
        self::$_db->bind(":id", $id);

        try{

            self::$_db->execute();
            $result = self::$_db->singleResult();

            if($result){
                return self::convertCustomersToStdClass($result);
            }else {
                $error = new stdClass;
                $error->error = "No customer with this id.";
                return $error;
            }

        }catch (Exception $e){
            return self::returnError($e);
        }


    }

    public static function updateCustomer($profile){

        $sql = "
        START TRANSACTION;

        UPDATE customers
        SET 
        address = :address
        WHERE userID = :userID;

        UPDATE users
        SET
        password = :password,
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

        self::$_db->bind(":address", $profile->address);

        try{
            self::$_db->execute();
            return $profile;

        } catch(PDOException $e){
            return self::returnError($e);
        }

    }

    public static function addCustomer($user){

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
            $sql = 'INSERT INTO customers(userID) 
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

    private static function convertCustomersToStdClass($results){

        if(is_array($results)){
            $std_customers = array();

            foreach($results as $customer){
                $s = new StdClass;
    
                self::copyCustomerPropertiesOver($customer, $s);
    
                $std_customers[] = $s;
            }

            return $std_customers;

        } else{

            $s = new StdClass;
            self::copyCustomerPropertiesOver($results, $s);
            return $s;

        }

    }

    private static function copyCustomerPropertiesOver($customer, $std_customer){
        
        // User info
        $std_customer->userID = $customer->getUserID();
        $std_customer->password = $customer->getPassword();
        $std_customer->role = $customer->getRole();
        $std_customer->firstName = $customer->getFirstName();
        $std_customer->lastName = $customer->getLastName();
        $std_customer->profilePic = $customer->getProfilePic();
        $std_customer->signUpDate = $customer->getSignUpDate();
        $std_customer->gender = $customer->getGender();
        $std_customer->phoneNumber = $customer->getPhoneNumber();
        $std_customer->email = $customer->getEmail();

        // Customer info
        $std_customer->address = $customer->getAddress();

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