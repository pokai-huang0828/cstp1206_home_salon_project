<?php 

class UserDAO{

    public static $users = array();

    public static function refreshUsers() {

        $fileContent = FileService::readFile(USER_DATA);
        Self::$users = UserParser::parseUser($fileContent);

    }


}

?>