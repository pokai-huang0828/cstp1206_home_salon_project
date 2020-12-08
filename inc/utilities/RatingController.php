<?php   

require_once("../config.inc.php");

require_once("../entities/User.class.php");
require_once("../entities/Stylist.class.php");
require_once("../entities/Rating.class.php");

require_once("PDOService.class.php");
require_once("RatingDAO.class.php");
require_once("StylistDAO.class.php");

// Initialize PDO
RatingDAO::init();

// Get Request Payload
$requestData = json_decode(file_get_contents("php://input"));

// var_dump($requestData);

// REST API HTTP Verbs
switch($_SERVER["REQUEST_METHOD"]){

    case "POST":
        // Customer rates Stylist, which in turn set Stylist Rating
        // return null if success, else return {error: error_msg}
        $res = RatingDAO::setStylistRating(
            $requestData->customerID, 
            $requestData->stylistID, 
            $requestData->rating
        );
        echo json_encode($res);
    break;

}

?>