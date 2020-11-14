<?php 

require_once("../config.inc.php");

require_once("../entities/Stylist.class.php");
require_once("../entities/User.class.php");
// require_once("../entities/StylistList.class.php");

require_once("FileService.class.php");
require_once("StylistParser.class.php");
require_once("StylistDAO.class.php");
require_once("SignUpService.class.php");

require_once("./UserParser.class.php");
require_once("./UserDAO.class.php"); 

// Get request payload
$requestData = json_decode(file_get_contents("php://input"));

//REST API 

switch($_SERVER["REQUEST_METHOD"]){

    case "POST":
        $user = SignUpService::signUp($requestData);

        // return the registered user + user->error (if any)
        echo json_encode($user);
    break;

}

?>