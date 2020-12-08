<?php  

class BookingDAO {

    private static $_db;

    public static function init(){
        self::$_db = new PDOService("Booking");
    }

    public static function getBookings($userID, $role){
        
        try{

            $customerBookingsSql = "SELECT b.bookingID, b.customerID, b.stylistID, 
                                    b.date, b.time, b.comment, b.status, 
                                    u.firstName, u.lastName
                                    FROM bookings as b
                                    JOIN users as u
                                    ON b.stylistID = u.userID
                                    WHERE customerID = :userID
                                    ORDER BY b.date;";

            $stylistBookingsSql = "SELECT b.bookingID, b.customerID, b.stylistID, 
                                    b.date, b.time, b.comment, b.status, 
                                    u.firstName, u.lastName 
                                    FROM bookings as b
                                    JOIN users as u
                                    ON b.customerID = u.userID
                                    WHERE stylistID = :userID
                                    ORDER BY b.date;";

            $sql = ($role == "customer") ? $customerBookingsSql : $stylistBookingsSql;
    
            self::$_db->query($sql);
            self::$_db->bind(":userID", $userID);
            self::$_db->execute();
            
            $res = self::$_db->getResults();

            // var_dump($res);
    
            return $res;

        } catch(Exception $e){
            return self::returnError($e);
        }
    }
    
    public static function customerCreateBooking($customerID, $stylistID, $date, $time, $comment){

        try{

            $sql = "INSERT INTO bookings
                    (customerID, stylistID, date, time, comment)
                    VALUES
                    (:customerID, :stylistID, :date, :time, :comment);
                    ";
    
            self::$_db->query($sql);
    
            self::$_db->bind(":customerID", $customerID);
            self::$_db->bind(":stylistID", $stylistID);
            self::$_db->bind(":date", $date);
            self::$_db->bind(":time", $time);
            self::$_db->bind(":comment", $comment);
    
            self::$_db->execute();
    
            $res = new StdClass();
            $res->bookingID = self::$_db->lastInsertKey();
    
            return $res;

        } catch(Exception $e){
            return returnError($e);
        }

    }

    public static function customerCancelBooking($bookingID){

        try{

            // check bookings status, return error if status = accepted or declined
            $sql = "SELECT status FROM bookings
                    WHERE bookingID = :bookingID;";
    
            self::$_db->query($sql);    
            self::$_db->bind(":bookingID", $bookingID);
            self::$_db->execute();
            
            $result =  self::$_db->getResult();
            $status = isset($result["status"]) ? $result["status"] : "booking not found";
    
            if($status == "pending"){

                // delete booking
                $sql = "DELETE FROM bookings
                        WHERE bookingID = :bookingID;";

                self::$_db->query($sql);    
                self::$_db->bind(":bookingID", $bookingID);
                self::$_db->execute();

            } else {

                // return error msg
                return self::returnErrorMessage("Could not cancel bookingID ".$bookingID." because it is in status: ".$status);
            }
    
        } catch(Exception $e){
            return returnError($e);
        }

    }

    public static function stylistSetBookingStatus($bookingID, $status){

        try {

            $sql = "UPDATE bookings
                    SET status = :status
                    WHERE bookingID = :bookingID";

            self::$_db->query($sql);
            self::$_db->bind(":bookingID", $bookingID);
            self::$_db->bind(":status", $status);

            self::$_db->execute();

        } catch(Exception $e){
            return self::returnError($e);
        }

    }

    private static function convertBookingToStdClass($results){

        if(is_array($results)){
            $std_bookings = array();

            foreach($results as $Booking){
                $s = new StdClass;
    
                self::copyBookingPropertiesOver($Booking, $s);
    
                $std_bookings[] = $s;
            }

            return $std_bookings;

        } else{

            $s = new StdClass;
            self::copyBookingPropertiesOver($results, $s);
            return $s;

        }

    }

    private static function copyBookingPropertiesOver($booking, $std_booking){

        // User info
        $std_booking->bookingID = $booking->getBookingID();
        $std_booking->customerID = $booking->getCustomerID();
        $std_booking->stylistID = $booking->getStylistID();
        $std_booking->date = $booking->getDate();
        $std_booking->time = $booking->getTime();
        $std_booking->comment = $booking->getComment();
        $std_booking->status = $booking->getStatus();

    }

    private static function returnError($e){
        $error = new stdClass;
        $error->error = $e->getMessage();
        return $error;
    }

    private static function returnErrorMessage($message){
        $error = new stdClass;
        $error->error = $message;
        return $error;
    }

}


?>