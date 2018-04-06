<?php

// require_once(__DIR__ . '/answer.php');
/*
*First Search method*
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
TODO; Add functionality to determine whether we need to find "100g" or any permutations of it
*/
require_once (__DIR__ . '/determineValue.php');



function filterJSONresponse($response)
{
	$finalJSON = new stdClass();
	$finalJSON->aglo1 = firstSearch($response);
	$finalJSON->algo2 = secondSearch($response);
	$finalJSON->algo3 = thirdSearch($response);
	
	return json_encode($finalJSON);	
}

/*
	First Method
	
	
	
	Param: OCRResponse
	Returns: JSONOutput
	Additional Functions Used: findObject(), getMedianX(), getMedianY(), getResult()
*/
function firstSearch($response)
{
	$jsonReturn = new stdClass();
	$gram100Box = findObject("100g", $response);
	if ($gram100box == NULL)
	{	
		$gram100box = findObject("100ml", $response);
	}
	$xColumn = getMedianX($gram100Box);

	
	$energyBox = findObject("ENERGY", $response);
	$yRow = getMedianY($energyBox);
	$nutrient = "ENERGY ";
	$jsonReturn->Energy= getResult($response,$xColumn, $yRow, $nutrient);
	
		
	$fatBox = findObject("FAT", $response);

	$yRow = getMedianY($fatBox);
	$nutrient = "Fat ";
	$jsonReturn->Fat= getResult($response,$xColumn, $yRow, $nutrient);
	
	$saturatesBox = findObject("saturates", $response);
	$nutrient = "Of which saturates ";
	$yRow = getMedianY($saturatesBox);
	$jsonReturn->Saturates = getResult($response,$xColumn, $yRow, $nutrient);
	
	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient)))
	{
		$jsonReturn->Saturates = getResult($response,$xColumn, $yRow, $nutrient);
	}
	
	
	$carbBox = findObject("CARBOHYDRATE", $response);
	if ($carbBox == NULL)
	{	
		$carbBox = findObject("Carbohydrate", $response);
	}
	$yRow = getMedianY($carbBox);
	$nutrient = "Carbohydarates ";
	$jsonReturn->Carbohydrates = getResult($response,$xColumn, $yRow, $nutrient);
	

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
	if ($fibreBox == NULL)
	{	
		$fibreBox = findObject("FIBRE", $response);
	}
	$yRow = getMedianY($fibreBox);
	$nutrient = "Fibre ";

	$jsonReturn->Fibre = getResult($response,$xColumn, $yRow, $nutrient);
	

	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){
		$jsonReturn->Fibre = getResult($response,$xColumn, $yRow, $nutrient);
	}


	$proteinBox = findObject("Protein", $response);
	if ($proteinBox == NULL)
	{	
		$gram100box = findObject("PROTEIN", $response);
	}
	$yRow = getMedianY($proteinBox);
	$nutrient = "Protein ";

	$jsonReturn->Protein = getResult($response,$xColumn, $yRow, $nutrient);
	

	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){
		$jsonReturn->Protein = getResult($response,$xColumn, $yRow, $nutrient);
	}	


	$saltBox = findObject("Salt", $response);
	if ($saltBox == NULL)
	{	
		$saltBox = findObject("SALT", $response);
	}
	$yRow = getMedianY($saltBox);
	$nutrient = "Salt ";

	$jsonReturn->Salt = getResult($response,$xColumn, $yRow, $nutrient);
	
	getResult($response,$xColumn, $yRow, $nutrient);
	
	echo("\n");
	echo("\n");
	

	if (determineValue(getResult($response,$xColumn, $yRow, $nutrient))){
		$jsonReturn->Salt = getResult($response,$xColumn, $yRow, $nutrient);
	}

	return json_encode($jsonReturn);

}


/*
	Second Method
*/

/*
*Second Read Label Method getNewBoxCoord()*

Works on the assumption that the food label has a consistent layout ie its always in the order of Energy, Fat .... Salt

Finds the "100g" box
Extracts the co-ordinates and creates a larger box
The program then checks the co-ordinates of the rest of the objects in the JSON to determine if they're inside the larger box

Hugely dependant on the quality of the JSON returned from the OCR
Returns better output vs orginal for hamsambo.jpg 
Returns correct values for noodles.jpg
Returns correct values for pisachio.jpg- need to work on tolerances

Param: OCRResponse
Returns: JSON Output
Dependancies: findObject(), getNewBoxCoord(), collidesWideBox().

*/

function secondSearch($response)
{
	$gram100Box = findObject("100g", $response);
	$JSONreturn = new stdClass();
	if ($gram100Box == NULL)
	{
		$gram100Box = findObject("100ml", $response);
	}

	$array = getNewBoxCoord($gram100Box);
	$minXCoord = $array[0]; 
	$maxXCoord = $array[1]; 
	$maxYCoord = $array[2]; 
	$minYCoord = $array[3]; 
	$nutrientArray = array("Energy", "Fat", "saturates", "Carbohydrate", "sugars", "Fibre", "Protein", "Salt");
	$index = 0;

	//$gram100Box = findObject("100g**", $response);


	foreach($response->textAnnotations as $box)
		{
			
			$secondReturn = collidesWideBox($box, $minXCoord, $maxXCoord, $maxYCoord, $minYCoord, $nutrient);
			if ($secondReturn != NULL)
			{
											// Fills the output in JSON format
				switch ($index)
				{
				case 0:
						$JSONreturn->Energy = $secondReturn;
						$index++;
						break;
				case 1:
						$JSONreturn->Fat = $secondReturn;
						$index++;
						break;		
				case 2:
						$JSONreturn->SaturatedFat = $secondReturn;
						$index++;
						break;		
				case 3:
						$JSONreturn->Carbohydrate = $secondReturn;
						$index++;
						break;		
				case 4:
						$JSONreturn->WhichOfSugars = $secondReturn;
						$index++;
						break;		
				case 5:
						$JSONreturn->Fibre = $secondReturn;
						$index++;
						break;		
				case 6:
						$JSONreturn->Protein = $secondReturn;
						$index++;
						break;		
				case 7:
						$JSONreturn->Salt = $secondReturn;
						$index++;
						break;	
								
				}
			}
		}
	return $JSONreturn;		

}



/*
*Third Read Label Method boxSearch()*

Finds each nutrient names and retrives its co-ordinates
Creates a box and extends the right most side
Uses the new box and check co-ordinates of the rest of the objects in the JSON
Returns the objects that lie inside the newly created box

Param: OCRresponse
Returns: JSON Output
Additional Functions Used: findObject(), nutrientBox(), getResultRightSearch()
*/



function thirdSearch($response)
{
	$jsonReturn = new stdClass();

	//$gram100Box = findObject("100g", $response);
	/*
		Third Method
	*/
	
	$nutrientArray = array("Energy", "Fat", "saturates", "Carbohydrate", "sugars", "Fibre", "Protein", "Salt",
							"ENERGY", "FAT", "SATURATES", "CARBOHYDRATES", "SUGARS", "FIBRE", "PROTEIN", "SALT");
							
	foreach($nutrientArray as $nutrient)
	{
		$energyCBox = findObject($nutrient, $response);
	
		$array = nutrientBox($energyCBox);
		$maxYValue = $array[0]; 
		$minYValue = $array[1];
		$xValueRight = $array[2]; 
		$xValueLeft = $array[3];
		$index = 0;
		
		
		foreach($response->textAnnotations as $box)
		{
			
			$secondReturn = getResultRightSearch($box, $maxYValue, $minYValue, $xValueRight, $xValueLeft, $nutrient);
			if ($secondReturn != NULL)
			{
				
				switch ($index)
				{
				case 0:
						$JSONreturn->Energy = $secondReturn;
						$index++;
						break;
				case 1:
						$JSONreturn->Fat = $secondReturn;
						$index++;
						break;		
				case 2:
						$JSONreturn->SaturatedFat = $secondReturn;
						$index++;
						break;		
				case 3:
						$JSONreturn->Carbohydrate = $secondReturn;
						$index++;
						break;		
				case 4:
						$JSONreturn->ofWhichSugars = $secondReturn;
						$index++;
						break;		
				case 5:
						$JSONreturn->Fibre = $secondReturn;
						$index++;
						break;		
				case 6:
						$JSONreturn->Protein = $secondReturn;
						$index++;
						echo($secondReturn);
						break;		
				case 7:
						$JSONreturn->Salt = $secondReturn;
						$index++;
						break;	
				}
			}
		
		}
		return $JSONreturn;

	}
}	

// Echo result of collides to console
// TODO; add results into an array or JSON then print
// First search method
/*
	Param: OCRresponse, Nutrient Name, co-ordiantes for collides method
	Returns: Description of box if inside co-ordiantes

*/
function getResult($response, $xColumn, $yRow, $nutirent)	
{
	foreach ($response->textAnnotations as $box)
	{
		if ($box != $response->textAnnotations[0])
			{
				if(collides($box, $xColumn, $yRow))
				{
					return $box->description;
				}
			}
	}
}


/*
	Second Search Method
	Parameters: OCRresponse, Co-ordinates of new box, nutrient name
	Returns: Description of box
*/

function getResult100gWideBox($response, $minXCoord, $maxXCoord, $maxYCoord, $minYCoord, $nutrient)	
{
	if(collidesWideBox($box, $minXCoord, $maxXCoord, $maxYCoord, $minYCoord, $nutrient))
	{
		return ($box->description);
	}
	
}
/*
	Third Search Method
	Parameters: OCRresponse, Co-ordinates of new box, nutrient name
	Return results on third search
*/
function getResultRightSearch($box, $maxYValue, $minYValue, $xValueRight, $xValueLeft, $nutrient)	
{
	if(nutrientValue($box, $maxYValue, $minYValue, $xValueRight, $xValueLeft, $nutrient))
	{
		return $box->description;
	}
}

/*
	First Search Method
	Return results on first search method and prints them
*/

function collides($box, $xVal, $yVal)
{

	$verts = $box->boundingPoly->vertices;
	
	if ($xVal > min($verts[0]->x, $verts[3]->x) && 
		$xVal < max($verts[1]->x, $verts[2]->x) &&
		$yVal > min($verts[0]->y, $verts[1]->y) && 
		$yVal < max($verts[2]->y, $verts[3]->y))
		{
			return true;
		}
		return false;
}


/*
	First Search Method
*/
function getMedianX($object)
{
	$ver = $object->boundingPoly->vertices;

	if ($ver != NULL)
	{
		foreach ($ver as $vertice)
		{
			$xRunningTotal += $vertice->x;
		}
	}
	return $xRunningTotal/4;
}
	
	/*
	First Search Method	
	*/
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


/*
	Second Search Method
	Param: "Box" or object in OCRresponse
	Returns: new box Co-ordinates
*/

function getNewBoxCoord($box)
{
	$verts = $box->boundingPoly->vertices;
	$x0 = $verts[0]->x;
	$y0 = $verts[0]->y;
	$x1 = $verts[1]->x;
	$y1 = $verts[1]->y;
	$x2 = $verts[2]->x;
	$y2 = $verts[2]->y;
	$x3 = $verts[3]->x;
	$y3 = $verts[3]->y;
	
	$yLength = $y2-$y1;
	$yLength = $yLength*11;
	$yLimit = $y2 + $yLength;
	
	$minYCoord = $y2;
	$maxYCoord = $yLimit;
	
	$tolerance = ($x0+$x1)*0.3;	
	$minXCoord = $x3-$tolerance;
	$maxXCoord = $x2+$tolerance;

	$coord = array($minXCoord, $maxXCoord, $maxYCoord, $minYCoord);
	return $coord;
}

/*
	Second Search Method
	Param: "Box" or object in OCRResponse, Co-ordinates of new box, Nutrient name
	Returns: Description of object which is located inside the new box
*/
function collidesWideBox($box, $minXCoord, $maxXCoord, $maxYCoord, $minYCoord, $nutrient)
{
	$verts = $box->boundingPoly->vertices;
	
	if ($verts[3]->y <= $maxYCoord && 
		$verts[3]->x >=$minXCoord && 
		$verts[2]->x <= $maxXCoord && 
		$verts[0]->y >= $minYCoord)
	{
		return $box->description;
	}
	return false;
}

/*
	Third Search Method
	Param: "Box" or object in OCRResponse
	Returns: Array of co-ordinates of new box
*/

function nutrientBox($box)
{

	$verts = $box->boundingPoly->vertices;			//Extracts all Co-ordinate values from box
	$x0 = $verts[0]->x;
	$y0 = $verts[0]->y;
	$x1 = $verts[1]->x;
	$y1 = $verts[1]->y;
	$x2 = $verts[2]->x;
	$y2 = $verts[2]->y;
	$x3 = $verts[3]->x;
	$y3 = $verts[3]->y;
	

	
	$yLength = $y2-$y1;								
	$yTolerance = $yLength*1;						
	$y2 = $y2 + $yTolerance;						
	$y1 = $y1 - $yTolerance;
	
	$maxYValue = $y2;
	$minYValue = $y1;	
	
	$xLength = $x1 - $x0;
	$xTolerance = $xLength*100;
	$xValueRight = $x1 + $xTolerance;
	$xValueLeft = $x3*.95;

	$values = array($maxYValue, $minYValue, $xValueRight, $xValueLeft);
	return $values;
}

/*
	Third Search Method
	Param: "Box" or object in OCRResponse, Co-ordinates of new box, Nutrient name
	Returns: True, if "box" is inside the new box created
			 False, if outside
*/

function nutrientValue($box, $maxYValue, $minYValue, $xValueRight, $xValueLeft, $nutrient)
{
	$verts = $box->boundingPoly->vertices;

	if ($verts[0]->y >= $minYValue && 
		$verts[2]->y <= $maxYValue && 
		$verts[3]->x >= $xValueLeft && 
		$verts[2]->x <= $xValueRight)
	
	{
		return true;
	}
	return false;
}

?>
