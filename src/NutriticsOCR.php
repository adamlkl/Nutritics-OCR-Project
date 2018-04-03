<?php
//require 'vendor/autoload.php';
// # Includes the autoloader for libraries installed with composer
require __DIR__ . '/../vendor/autoload.php';

require_once(__DIR__ . '/google_ocr.php');
require_once(__DIR__ . '/filter.php');

header('Content-type: application/json');

class NutriticsOCR{

private $result;
    
    public function __construct($postData){
        if (isset($_POST['submit'])){
            $file = $_FILES['file'];
            $fileName=$_FILES['file']['name'];
            $fileTmpName=$_FILES['file']['tmp_name'];
            $fileSize=$_FILES['file']['size'];
            $fileError=$_FILES['file']['error'];
            $fileType=$_FILES['file']['type'];
            
            if ($fileError===0 && $fileSize<1000000){
                $this->result=$this->process($postData);
            }
        }
    }

    private function process ($image){
        $json_response = getOCRResponseJSON($image);
        $response = json_decode($json_response);
        return filterJSONresponse($response);
    }

    public function getResult (){
        return $this->result;
    }
}
?>
