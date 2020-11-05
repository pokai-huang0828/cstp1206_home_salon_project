<?php 

class User {

    protected string $userID;
    protected string $password;
    protected string $role;
    protected string $firstName;
    protected string $lastName;
    protected string $profilePic;
    protected string $signUpDate;
    protected string $gender;
    protected string $phoneNumber;
    protected string $email;

    function __construct (
        string $aUserID,
        string $aPassword,
        string $aRole,
        string $aFirstName,
        string $aLastName,
        string $aProfilePic,
        string $aSignUpDate,
        string $aGender,
        string $aPhoneNumber,
        string $aEmail
    ){
        $this->userID = $auserID;
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

    public function getUserID() {
        return $this->userID;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getRole() {
        return $this->role;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSignUpDate() {
        return $this->signUpDate;
    }
    
    public function getProfilePic() {
        return $this->profilePic;
    }
}

?>