<?php
//require 'vendor/autoload.php';
// # Includes the autoloader for libraries installed with composer
require __DIR__ . '/../vendor/autoload.php';

require_once(__DIR__ . '/google_ocr.php');

header('Content-type: application/json');

print_r(getOCRResponseJSON(fopen('/app/tests/testdata/images/noodles.jpg', 'r')));
?>