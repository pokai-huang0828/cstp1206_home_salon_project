<?php  

class BookingDAO {

    private static $_db;

    public static function init(){
        self::$_db = new PDOService("Booking");
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