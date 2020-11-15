<?php 

class StylistParser{

    public static $stylists = array();

    public static function parseStylists(string $fileContents){

        try {

            $lines = explode("\n", $fileContents);

            //Check the number of columns is correct
            for ($i =1; $i < count($lines); $i++){
                $col = explode(',', $lines[$i]);

                if(count($col) != 7) throw new Exception("Invalid data at row ".($i + 1));

                $ns = new Stylist;

                $ns->setUserID($col[0]);
                $ns->setProfessionalExperience($col[1]);
                $ns->setRating($col[2]);
                $ns->setServiceLocation($col[3]);
                $ns->setCategory($col[4]);
                $ns->setPriceList($col[5]);
                $ns->setPortfolio($col[6]);

                self::$stylists[] = $ns;

            }
            
            return self::$stylists;

        } catch (Exception $ex){
            echo $ex.getMessage();
        }

    }


}


?>