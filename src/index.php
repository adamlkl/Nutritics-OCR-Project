<?php
//require 'vendor/autoload.php';
// # Includes the autoloader for libraries installed with composer

header('Content-type: application/json');
require __DIR__ . '/../vendor/autoload.php';

require_once(__DIR__ . '/google_ocr.php');

require_once(__DIR__ . '/filter.php');



$json_response = getOCRResponseJSON(fopen('/app/tests/testdata/images/pistachio.jpg', 'r'));
$response = json_decode($json_response);

$final = filterJSONresponse($response);

print_r($final);

?>
