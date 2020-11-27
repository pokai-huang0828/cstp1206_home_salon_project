<?php 

class SignUpService {

    public static function signUp($inputs){

        // Convert StdClass to User
        $user = self::createUser($inputs);

        switch ($inputs->role){
            
            case "stylist":
                StylistDAO::init();
                return StylistDAO::addStylist($user);
            break;

            case "customer":
                CustomerDAO::init();
                return CustomerDAO::addCustomer($user);
            break;
        }

    }

    private static function createUser($input){
        
        $u = new User();

        // set user
        $u->setSignUpDate(date("Y-m-d"));
        $u->setPassword($input->password);
        $u->setRole($input->role);
        $u->setFirstName($input->firstName);
        $u->setLastName($input->lastName);
        $u->setGender(strtolower($input->gender));
        $u->setPhoneNumber($input->phoneNumber);
        $u->setEmail(strtolower($input->email));

        return $u;
    }

    private static function getUserByEmail($emailInput){
        UserDAO::init();
        return UserDAO::getUserByEmail($emailInput);
    }

}



?>