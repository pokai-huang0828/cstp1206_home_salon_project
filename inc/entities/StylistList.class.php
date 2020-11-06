<?php 

class StylistList{

    private static array $stylists;

    public function getStylistList(){
        return self::$stylists;
    }

    public function setStylistList($aStylistList){
        self::$stylistList = $aStylistList;
    }

}

?>