<?php  

require_once("../config.inc.php");

require_once("../entities/Stylist.class.php");
require_once("../entities/User.class.php");

require_once("PDOService.class.php");
require_once("StylistDAO.class.php");
require_once("./UserDAO.class.php"); 

// Initialize PDO
StylistDAO::init();

// Get Request Payload
$requestData = json_decode(file_get_contents("php://input"));

// var_dump($requestData);

// REST API HTTP Verbs

switch($_SERVER["REQUEST_METHOD"]){

    case "GET":

        // Get queries string
        $queries = array();
        parse_str($_SERVER['QUERY_STRING'], $queries);

        // If the payload contains a userID
        if(isset($queries["userID"])){

            // Return the stylist
            $stylist = StylistDAO::getStylistById($queries["userID"]);
            echo json_encode($stylist);
        } else {

            // Return all stylists as an array 
            $stylists = StylistDAO::getStylists();
            echo json_encode($stylists);
        }

    break;

    case "PUT":
        // the payload should come in with the stylist properties + stylist ID
        $updatedProfile = StylistDAO::updateStylists($requestData);
        echo json_encode($updatedProfile);
    break;

}






?>