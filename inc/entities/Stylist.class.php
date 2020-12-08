<?php 

require_once("User.class.php");

class Stylist extends User{

    protected string $userID;
    private int $professionalExperience;
    private float $rating;
    private string $serviceLocation;
    private string $category;
    private string $priceList;
    private string $portfolio;

    // Getters
    public function getUserID(){
        return $this->userID;
    }
    public function getProfessionalExperience(){
        return $this->professionalExperience;
    }
    public function getRating(){
        return $this->rating;
    }
    public function getServiceLocation(){
        return $this->serviceLocation;
    }
    public function getCategory(){
        return $this->category;
    }
    public function getPriceList(){
        return $this->priceList;
    }
    public function getPortfolio(){
        return $this->portfolio;
    }

    // Setters
    public function setUserID($aUserID){
        $this->userID = $aUserID;
    }
    public function setProfessionalExperience($aProfessionalExperience){
        $this->professionalExperience = $aProfessionalExperience;
    }
    public function setRating($aRating){
        $this->rating = $aRating;
    }
    public function setServiceLocation($aServiceLocation){
        $this->serviceLocation = $aServiceLocation;
    }
    public function setCategory($aCategory){
        $this->category = $aCategory;
    }
    public function setPriceList($aPriceList){
        $this->priceList = $aPriceList;
    }
    public function setPortfolio($aPortfolio){
        $this->portfolio = $aPortfolio;
    }
    
}


?>