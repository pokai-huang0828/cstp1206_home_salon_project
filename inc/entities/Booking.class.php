<?php 

class Booking {

    private string $bookingID;
    private string $customerID;
    private string $stylistID;
    private string $date;
    private string $time;
    private string $comment;
    private string $status;

    public function getBookingID(){
        return $this->bookingID;
    }
    public function getCustomerID(){
        return $this->customerID;
    }
    public function getStylistID(){
        return $this->stylistID;
    }
    public function getDate(){
        return $this->date;
    }
    public function getTime(){
        return $this->time;
    }
    public function getComment(){
        return $this->comment;
    }
    public function getStatus(){
        return $this->status;
    }

    public function setBookingID($aBookingID){
        $this->bookingID= $aBookingID;
    }
    public function setCustomerID($aCustomerID){
        $this->customerID= $aCustomerI;
    }
    public function setStylistID($aStylistID){
        $this->stylistID= $aStylistID;
    }
    public function setDate($aDate){
        $this->date= $aDate;
    }
    public function setTime($aTime){
        $this->time= $aTime;
    }
    public function setComment($aComment){
        $this->comment= $aComment;
    }
    public function setStatus($aStatus){
        $this->status;
    }

}

?>