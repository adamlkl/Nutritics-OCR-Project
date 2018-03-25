<?php

// require_once(__DIR__ . '/answer.php');
/*
method
find 100g column
get its central x point
search for serving size
For every box in json
if collides with a search point
read text in box and store in relevant nutritional element.
else if description is one of our nutritional headings
get average y value of corners (middle of box)
use to find an intersection with x from 100g column
add intersection as a search point for that nutriotional value
*/

/*
datastructures needed:
array of 7 nutritional headings (fat, energy etc)
corresponding array of 7 vertices where to expect the nutrition quantities
blank json response to fill with answer
*/

/*
All nutrient names are case sensitive in the JSONResponse
TODO; Add functionality to determine whether we need to find "100g" or any permuation of it
*/
require_once (__DIR__ . '/determineValue.php');

function filterJSONresponse($response)
{
	$jsonReturn = new stdClass();
	$gram100Box = findObject("100g**", $response);

	$xColumn = getMedianX($gram100Box);
	$fatBox = findObject("Fat", $response);
	$yRow = getMedianY($fatBox);
	$nutrient = "Fat ";
	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){
		$jsonReturn->Fat = getResult($response,$xColumn, $yRow, $nutrient);
	}

	$saturatesBox = findObject("saturates", $response);
	$nutrient = "Of which saturates ";
	$yRow = getMedianY($saturatesBox);
	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){
		$jsonReturn->Saturates = getResult($response,$xColumn, $yRow, $nutrient);
	}

	$carbBox = findObject("Carbohydrate", $response);
	$yRow = getMedianY($carbBox);
	$nutrient = "Carbohydrates ";
	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){
		$jsonReturn->Carbohydrates = getResult($response,$xColumn, $yRow, $nutrient);
	}

	$sugarsBox = findObject("sugars", $response);
	$nutrient = "Of which sugars ";
	$yRow = getMedianY($sugarsBox);
	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){	
		$jsonReturn->Sugars = getResult($response,$xColumn, $yRow, $nutrient);
	}

	$fibreBox = findObject("Fibre", $response);
	$yRow = getMedianY($fibreBox);
	$nutrient = "Fibre ";
	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){
		$jsonReturn->Fibre = getResult($response,$xColumn, $yRow, $nutrient);
	}

	$proteinBox = findObject("Protein", $response);
	$yRow = getMedianY($proteinBox);
	$nutrient = "Protein ";
	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){
		$jsonReturn->Protein = getResult($response,$xColumn, $yRow, $nutrient);
	}	

	$saltBox = findObject("Salt", $response);
	$yRow = getMedianY($saltBox);
	$nutrient = "Salt ";
	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){
		$jsonReturn->Salt = getResult($response,$xColumn, $yRow, $nutrient);
	}

	return json_encode($jsonReturn);
}

// Echo result of collides to console
// TODO; add results into an array or JSON then print

function getResult($response, $xColumn, $yRow, $nutirent)
{
	foreach ($response->textAnnotations as $box)
	{
		if ($box != $response->textAnnotations[0])
		{
		if(collides($box, $xColumn, $yRow))
		{
			//echo($nutirent);
			return($box->description);
			// echo("\n");
		}
		}
	}
	$topLeft = $object->boundingPoly->vertices[0]->x;
	echo($topLeft);

}

function collides($box, $xVal, $yVal)
{
	$verts = $box->boundingPoly->vertices;

	if ($xVal > min($verts[0]->x, $verts[3]->x) && $xVal < max($verts[1]->x, $verts[2]->x) &&
		$yVal > min($verts[0]->y, $verts[1]->y) && $yVal <max($verts[2]->y, $verts[3]->y))
		{

		return true;

		}
		return false;
}

function getMedianX($object)
{
	$ver = $object->boundingPoly->vertices;
	//echo('hi');
	//echo(var_dump($box));
	if ($ver != NULL)
	{
	//echo("hi");
	foreach ($ver as $vertice)
		{
			# code...
			$xRunningTotal += $vertice->x;
	//		echo($xRunningTotal);
		}
	}
	return $xRunningTotal/4;
}



function getMedianY($object)
{
	$ver = $object->boundingPoly->vertices;
	if ($ver != NULL)
	{
	foreach ($ver as $vertice)
	{
		# code...
		$yRunningTotal += $vertice->y;
	}
	}
	return $yRunningTotal/4;
}




function findObject($string, $response)
{
	foreach($response->textAnnotations as $text)
	{
		if ($text->description == $string || checkSimilarity($text->description)==$string)
		{
			return $text;
		}
	}
}

?>
