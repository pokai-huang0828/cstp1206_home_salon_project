<?php 

class FileService {

    public static function readfile($fileName){

        try {

            //Get a file handle
            $fh = fopen($fileName, 'r');

            if(!$fh) throw new Exception("Could not open fileName ".$fileName);
            
            //Read contents
            $contents = fread($fh, fileSize($fileName));

            //close file
            fclose($fh);


        } catch(Exception $ex){
            echo $ex->getMessage();
        }

        return $contents;

    }

    public static function writeFile($fileName, $content){

        try{

            //Get the file handle
            $fh = fopen($fileName, 'w');

            if(!$fh) throw new Exception("Could not open file: ".$fileName);

            fwrite($fh, $content);

            fclose($fh);

        } catch(Exception $ex){

            $ex->getMessage();
        }

    }


}



?>
