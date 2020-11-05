<?php 

require_once("inc/entities/User.class.php");

class Stylist extends User{

    private int $professionalExperience;
    private float $rating;
    private array $category;
    private string $priceList;
    private array $portfolio;

    function __construct(
        User $user, 
        int $aProfessionalExperience,
        int $aRating,
        int $aCategory,
        int $aPriceList,
        int $aPortfolio
    ){
        $this->userID = $user->userID;
        $this->password = $user->password;
        $this->role = $user->role;
        $this->firstName = $user->firstName;
        $this->lastName = $user->lastName;
        $this->profilePic = $user->profilePic;
        $this->signUpDate = $user->signUpDate;
        $this->gender = $user->gender;
        $this->phoneNumber = $user->phoneNumber;
        $this->email = $user->email;

        $this->professionalExperience = $aProfessionalExperience;
        $this->rating = $aRating;
        $this->category = $aCategory;
        $this->priceList = $aPriceList;
        $this->portfolio = $aPortfolio;
    }

    public function getUserID(){
        return $this->userID;
    }
    public function getRating(){
        return $this->rating;
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
    
}


?>