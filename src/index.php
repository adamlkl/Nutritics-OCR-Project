
<?php
//require 'vendor/autoload.php';
// # Includes the autoloader for libraries installed with composer


require __DIR__ . '/../vendor/autoload.php';

require_once(__DIR__ . '/google_ocr.php');

require_once(__DIR__ . '/filter.php');



$json_response = getOCRResponseJSON(fopen('/app/tests/testdata/images/soup.jpeg', 'r'));
$response = json_decode($json_response);

$final = filterJSONresponse($response);

print_r($final);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
    <title></title>
    <style type = "text/css">
    	body {
    		font-family : Georgia,Times,serif;
    	}
    	h1 {
    		font-family:  "Courier New", Courier, monospace;
    		font-size: 16px;
    		padding-top: 20px;
    		padding-left: 480px;
    	}
    </style>
</head>
<body>
	<h1>Nutritics OCR API Demo</h1>
	<div class="grid">
		<div>
           <?php require_once(__DIR__ . '/NutriticsOCR.php'); ?>

    

            <?php $result = (new NutriticsOCR($POST))->getResult(); ?>

			<form method="POST" enctype="multipart/form-data" name="uploadForm">
    		<input type="file" name="file">
    		<button type="submit" name="submit" style="font-size: 12px; font-family: cambria; height: 18px; width:70px;">UPLOAD</button></div>
		<div style="font-family: Ariel,Courier,serif; font-size: 18px;">Result:<br/><?php print_r($result); ?></div>
	</div>
</form>
</body>

</html>

</html>