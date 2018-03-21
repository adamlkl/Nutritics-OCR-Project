<?php
//require 'vendor/autoload.php';
// # Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';
require_once(__DIR__ . '/google_ocr.php');
require_once(__DIR__ . '/filter.php');
header('Content-type: application/json');


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}









$json_response = getOCRResponseJSON(fopen($target_file, 'r'));
//print_r($json_response);
$response = json_decode($json_response);
filterJSONresponse($response);
/*
$key = array_search('Fat', $response);
echo($key);
*/
// check for consistency in output
/*
foreach($response->textAnnotations as $text)
{
	//echo($text->description);
	
	if ($text->description == "Fat")
	{
	echo($text->description);
	
	}
}
*/
//$result = array_filter($response['description'], function($fat)) 
//{
//return $fat
//}
/*
foreach($response['responses'][0]['textAnnotations'] as $box)
{
	
				$points = array();
				foreach($box['boundingPoly']['vertices'] as $vertex)
				{
					array_push($points, $vertex['x'], $vertex['y']);
				}
				
				imagepolygon($im, $points, count($box['boundingPoly']['vertices']), $red);
}
*/
//print_r($json_response);
//$response = json_decode($json_response, true);
//print_r($json_response);
//$Res = json_decode(getOCRResponseJSON(fopen('/app/tests/testdata/images/noodles.jpg', 'r')));
//$filterRes = json_decode($obj);
//print($filterRes);
//$JSONresponse = getOCRResponseJSON(fopen('/app/tests/testdata/images/noodles.jpg', 'r'));
//$obj = json_decode($JSONresponse);
//print $obj->{'Nutrition'};
?>