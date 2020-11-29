<?php 

require_once("../config.inc.php"); 

require_once("../entities/Stylist.class.php");
require_once("../entities/User.class.php");

require_once("PDOService.class.php");
require_once("StylistDAO.class.php");
require_once("SignInService.class.php");

require_once("./UserDAO.class.php"); 

// Get request payload
$requestData = json_decode(file_get_contents("php://input"));

//REST API 

switch($_SERVER["REQUEST_METHOD"]){ 

    case "POST":
        $user = SignInService::checkEmailAndPassword($requestData->email, $requestData->password);

        // return userID + user_info if credential is valid
        echo json_encode($user);
    break;

}

?>