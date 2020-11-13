<?php 

require_once("inc/config.inc.php");

require_once("inc/entities/Stylist.class.php");
require_once("inc/entities/User.class.php");
require_once("inc/entities/StylistList.class.php");

require_once("inc/utilities/FileService.class.php");
require_once("inc/utilities/StylistParser.class.php");
require_once("inc/utilities/StylistDAO.class.php");

require_once("inc/utilities/UserParser.class.php");
require_once("inc/utilities/UserDAO.class.php");

// $stylist_content = FileService::readfile(STYLIST_DATA);
// $stylists = StylistParser::parseStylists($stylist_content);
// var_dump($stylist_content);
// var_dump($stylists);

// $users_content = FileService::readfile(USER_DATA);
// $users = UserParser::parseUser($users_content);
// var_dump($users_content);
// var_dump($users);

$str = '{"name": ["a", "b"]}';
var_dump(json_decode($str));


?>