<?php 

class UserParser{

    public static $users = array();

    public static function parseUser(string $fileContents){

        try{

            $lines = explode("\n", $fileContents);

            for($i =1; $i < count($lines); $i++){

                $col = explode(',', $lines[$i]);

                if(count($col) != 10) throw new Exception("Data at ".($i+1));

                $u = new User;

                $u->setUserID($col[0]);
                $u->setPassword($col[1]);
                $u->setRole($col[2]);
                $u->setFirstName($col[3]);
                $u->setLastName($col[4]);
                $u->setProfilePic($col[5]);
                $u->setSignUpDate($col[6]);
                $u->setGender($col[7]);
                $u->setPhoneNumber($col[8]);
                $u->setEmail($col[9]);

                self::$users[] = $u;
            }

        } catch(Exception $ex) {
            echo $ex->getMessage();
        }

        return self::$users;

    }


}


?>