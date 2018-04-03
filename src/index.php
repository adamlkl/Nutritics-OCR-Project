<?php
//require 'vendor/autoload.php';
// # Includes the autoloader for libraries installed with composer
require __DIR__ . '/../vendor/autoload.php';

require_once(__DIR__ . '/google_ocr.php');

require_once(__DIR__ . '/filter.php');

header('Content-type: application/json');

$json_response = getOCRResponseJSON(fopen('/app/tests/testdata/images/pistachio.jpg', 'r'));
$response = json_decode($json_response);

$final = filterJSONresponse($response);

print_r($final);

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
