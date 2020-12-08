<?php 

class Rating {

    private string $customerID;
    private string $stylistID;
    private float $rating;

    public function getCustomerID(){
        return $this->customerID;
    }
    public function getStylistID(){
        return $this->stylistID;
    }
    public function getAddress(){
        return $this->address;
    }

    public function setCustomerID($aCustomerID){
        $this->customerID = $aCustomerID;
    }
    public function setStylistID($aStylistID){
        $this->stylistID = $aStylistID;
    }
    public function setRating($aRating){
        $this->rating = $aRating;
    }

}

?>
