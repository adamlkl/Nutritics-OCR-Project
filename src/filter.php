<?php
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
try hard coding values then calculating
*/

function filterJSONresponse($response)
{
	$gram100Box = findObject("100g**", $response);
	//echo($gram100Box->description);
	
	$xColumn = getMedianX($gram100Box);
	//echo($xColumn);
	$fatBox = findObject("Fat", $response);
	//echo($fatBox->boundingPoly->vertices[1]->x);
	$yRow = getMedianY($fatBox);
	
	
	// $verticeIntersection = vertice{
	// 	x: $xColumn,
	// 	y: $yColumn
	// };
	
	foreach ($response->textAnnotations as $box) 
	{
		if ($box != $response->textAnnotations[0])
		{
		if(collides($box, $xColumn, $yRow))
		{
			
			echo($box->description);
		}
		}
	}
	$topLeft = $object->boundingPoly->vertices[0]->x;
	echo($topLeft);
	
}

/*

function collides($box, $xVal, $yVal)
{
	if (!(($xVal < min($box->boundingPoly->vertices[0]->x, $box->boundingPoly->vertices[4]->x)
						|| $xVal > max($box->boundingPoly->vertices[1]->x, $box->boundingPoly->vertices[2]->x)
						|| $yVal < min($box->boundingPoly->vertices[0]->y, $box->boundingPoly->vertices[1]->y)
						|| $yVal > max($box->boundingPoly->vertices[3]->y, $box->boundingPoly->vertices[2]->y)
						)))
						{
							return false;						
						}
						return true;
}
*/

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
		if ($text->description == $string)
		{
			return $text;
		}
	}
}








?>