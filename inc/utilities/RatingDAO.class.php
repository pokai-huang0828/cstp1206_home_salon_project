<?php  

class RatingDAO {

    private static $_db;

    public static function init(){
        self::$_db = new PDOService("Rating");
    }
    
    public static function setStylistRating($customerID, $stylistID, $rating){

        // Call stylist init
        StylistDAO::init();
        
        // Check if this customer has rated before : return a Rating Obj or False
        $hasRated = self::checkIfCustomerHasRated($customerID);
        $stylistIDExists = StylistDAO::getStylistById($stylistID);

        try{
            // If this customer has rated before:
            if($hasRated && $stylistIDExists) {
    
                // Update Rating
                self::updateRating($customerID, $stylistID, $rating);
                
                // recalculate rating for that stylist
                $average = self::calculateStylistRating($stylistID);
                
                // set stylist rating
                StylistDAO::setStylistRating($stylistID, $average);
                
                
            } else {
                
                // Insert Rating
                self::insertRating($customerID, $stylistID, $rating);
    
                // recalculate rating for that stylist
                $average = self::calculateStylistRating($stylistID);
                
                // set stylist rating
                StylistDAO::setStylistRating($stylistID, $average);
    
            }

        } catch(Exception $e){
            self::returnErrorMessage("Could not updated rating.");
        }

    }

    public static function checkIfCustomerHasRated($customerID){
        
        $sql = "SELECT customerID FROM ratings
                WHERE customerID = :customerID;";

        self::$_db->query($sql);
        self::$_db->bind(":customerID", $customerID);
        self::$_db->execute();
        $hasRated = self::$_db->singleResult();

        return $hasRated;
    }

    public static function insertRating($customerID, $stylistID, $rating){

        $sql = "INSERT INTO ratings
                (customerID, stylistID, rating)
                VALUES
                (:customerID, :stylistID, :rating);";

        self::$_db->query($sql);
        self::$_db->bind(":customerID", $customerID);
        self::$_db->bind(":stylistID", $stylistID);
        self::$_db->bind(":rating", $rating);

        self::$_db->execute();

    }

    public static function updateRating($customerID, $stylistID, $rating){

        $sql = "UPDATE ratings
                SET rating = :rating
                WHERE customerID = :customerID AND stylistID = :stylistID;";

        self::$_db->query($sql);
        self::$_db->bind(":customerID", $customerID);
        self::$_db->bind(":stylistID", $stylistID);
        self::$_db->bind(":rating", $rating);

        self::$_db->execute();
    }

    private static function calculateStylistRating($stylistID){
        $sql = "SELECT AVG(rating) AS average
                FROM ratings
                WHERE stylistID = :stylistID;";

        self::$_db->query($sql);
        self::$_db->bind(":stylistID", $stylistID);

        self::$_db->execute(); 
        $result = self::$_db->getResult(); 

        return round(floatval($result['average']),1);
    }

    private static function convertRatingToStdClass($results){

            $s = new StdClass;
            self::copyRatingPropertiesOver($results, $s);
            return $s;

    }

    private static function copyRatingPropertiesOver($rating, $std_rating){
        
        // User info
        $std_rating->customerID = $rating->getCustomerID();
        $std_rating->stylistID = $rating->getStylistID();
        $std_rating->rating = $rating->getRating();

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