<?php
//require 'vendor/autoload.php';
// # Includes the autoloader for libraries installed with composer
<<<<<<< HEAD
require __DIR__ . '/../vendor/autoload.php';

require_once(__DIR__ . '/google_ocr.php');
require_once(__DIR__ . '/filter.php');

header('Content-type: application/json');

class NutriticsOCR{

=======
//header('Content-type: application/json');
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/google_ocr.php');
require_once(__DIR__ . '/filter.php');

class NutriticsOCR{
>>>>>>> 88dc67b9cb3a3bab88459cef8bc052ba20eebdc5
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
<<<<<<< HEAD
                $this->result=$this->process($postData);
            }
        }
    }

=======
                $this->result=$this->process(fopen($_FILES['file']['tmp_name'], 'r'));
            }
        }
    }
>>>>>>> 88dc67b9cb3a3bab88459cef8bc052ba20eebdc5
    private function process ($image){
        $json_response = getOCRResponseJSON($image);
        $response = json_decode($json_response);
        return filterJSONresponse($response);
    }
<<<<<<< HEAD

=======
>>>>>>> 88dc67b9cb3a3bab88459cef8bc052ba20eebdc5
    public function getResult (){
        return $this->result;
    }
}
<<<<<<< HEAD
?>
=======
?>
>>>>>>> 88dc67b9cb3a3bab88459cef8bc052ba20eebdc5
