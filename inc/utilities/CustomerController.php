<?php   

require_once("../config.inc.php");

require_once("../entities/Customer.class.php");
require_once("../entities/User.class.php");

require_once("PDOservice.class.php");
require_once("CustomerDAO.class.php");
require_once("./UserDAO.class.php"); 

// Initialize PDO
CustomerDAO::init();

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

            // Return the customer
            $customer = CustomerDAO::getCustomerById($queries["userID"]);
            echo json_encode($customer);

        } else {

            // Return all stylists as an array 
            $customers = CustomerDAO::getCustomers();
            echo json_encode($customers);

        }

    break;

    case "PUT":
        // the payload should come in with the customer properties + customer ID
        $updatedProfile = CustomerDAO::updateCustomer($requestData);
        echo json_encode($updatedProfile);
    break;

}






?>