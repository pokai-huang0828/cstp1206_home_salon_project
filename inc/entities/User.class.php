<?php 

class User{

    private string $userID;
    private string $password;
    private string $role;
    private string $firstName;
    private string $lastName;
    private string $profilePic;
    private string $signUpDate;
    private string $gender;
    private string $phoneNumber;
    private string $email;

    function __construct(
        string $aUserID ="",
        string $aPassword = "",
        string $aRole = "",
        string $aFirstName = "",
        string $aLastName = "",
        string $aProfilePic = "",
        string $aSignUpDate = "",
        string $aGender = "",
        string $aPhoneNumber = "",
        string $aEmail = ""
    ){
        $this->userID = $aUserID;
        $this->password = $aPassword;
        $this->role = $aRole;
        $this->firstName = $aFirstName;
        $this->lastName = $aLastName;
        $this->profilePic = $aProfilePic;
        $this->signUpDate = $aSignUpDate;
        $this->gender = $aGender;
        $this->phoneNumber = $aPhoneNumber;
        $this->email = $aEmail;
    }

    // Getters
    public function getUserID(){
        return $this->userID;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getFirstName(){
        return $this->firstName;
    }
    public function getLastName(){
        return $this->lastName;
    }
    public function getRole(){
        return $this->role;
    }
    public function getGender(){
        return $this->gender;
    }
    public function getPhoneNumber(){
        return $this->phoneNumber;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getSignUpDate(){
        return $this->signUpDate;
    }
    public function getProfilePic(){
        return $this->profilePic;
    }

        // Setters
        public function setUserID($aUserID){
            $this->userID = $aUserID;
        }
        public function setPassword($aPassword){
            $this->password = $aPassword;
        }
        public function setFirstName($aFirstName){
            $this->firstName = $aFirstName;
        }
        public function setLastName($aLastName){
            $this->lastName = $aLastName;
        }
        public function setRole($aRole){
            $this->role = $aRole;
        }
        public function setGender($aGender){
            $this->gender = $aGender;
        }
        public function setPhoneNumber($aPhoneNumber){
            $this->phoneNumber = $aPhoneNumber;
        }
        public function setEmail($aEmail){
            $this->email = $aEmail;
        }
        public function setSignUpDate($aSignUpDate){
            $this->signUpDate = $aSignUpDate;
        }
        public function setProfilePic($aProfilePic){
            $this->profilePic = $aProfilePic;
        }


}


?>