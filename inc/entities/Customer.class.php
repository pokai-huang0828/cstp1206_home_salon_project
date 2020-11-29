<?php 

require_once("User.class.php");

class Customer extends User{

    protected string $userID;
    private string $address;

    // function __contruct(
    //     string $aUserID = "",
    //     string $aAddress = ""
    // ){
    //     $this->userID = $aUserID;
    //     $this->address = $aAddress;
    // }

    public function getUserID(){
        return $this->userID;
    }
    public function getAddress(){
        return $this->address;
    }

    public function setUserID($aUserID){
        $this->userID = $aUserID;
    }
    public function setAddress($aAddress){
        $this->address = $aAddress;
    }

}



?>