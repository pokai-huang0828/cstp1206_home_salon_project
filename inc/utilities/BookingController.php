<?php   

require_once("../config.inc.php");
require_once("../entities/Booking.class.php");
require_once("PDOService.class.php");
require_once("BookingDAO.class.php");

// Initialize PDO
BookingDAO::init();

// Get Request Payload
$requestData = json_decode(file_get_contents("php://input"));

// REST API HTTP Verbs
switch($_SERVER["REQUEST_METHOD"]){

    case "GET":



    break;

    case "POST":

        // check if this is a customer request or stylist request
        if($requestData->role == "customer"){
            
            // customer want to create a booking 
            $res = BookingDAO::customerCreateBooking(
                $requestData->customerID,
                $requestData->stylistID,
                $requestData->date,
                $requestData->time,
                $requestData->comment
            );

            echo json_encode($res);
            
        } else {

            // return null on success, else error msg
            echo json_encode($res);
            
        }

    break;

    case "DELETE":

        if($requestData->role == "customer"){
            
            // customer want to cancel a booking; return null on success, else return error msg
            $res = BookingDAO::customerCancelBooking($requestData->bookingID);
            echo json_encode($res);

        }

    break;

}

?>