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
function filterJSONresponse($response)
{
	$gram100Box = findObject("100g", $response);
	echo($gram100Box->description);
	echo(</br>);
	$xColumn = findMedianX($gram100Box);
	$fatBox = findObject("Fat", $response);
	echo($fatBox->description);
	$yRow = findMedianY($fatBox);

	// $verticeIntersection = vertice{
	// 	x: $xColumn,
	// 	y: $yColumn
	// };
	foreach ($response->textAnnotations as $box) {
		# code...
		if(collides($box, $xColumn, $yRow))
		{
			echo("Fat " + $box->description);
		}
	}
	$topLeft = $object->boundingPoly->vertices[0]->x;

	echo($topLeft);

}

function collides($box, $xVal, $yVal)
{
	return !(($xVal < min($box->boundingPoly->vertices[0]->x, $box->boundingPoly->vertices[4]->x)
						|| $xVal > max($box->boundingPoly->vertices[1]->x, $box->boundingPoly->vertices[2]->x)
						|| $yVal < min($box->boundingPoly->vertices[0]->y, $box->boundingPoly->vertices[1]->y)
						|| $yVal > max($box->boundingPoly->vertices[3]->y, $box->boundingPoly->vertices[2]->y)
						)
}



function getMedianX($object)
{
	foreach ($box->boundingPoly->vertices as $vertice)
		{
			# code...
			$xRunningTotal += $vertice->x;
		}
		return $xRunningTotal/4;
	}

	function getMedianY($object)
	{
		foreach ($box->boundingPoly->vertices as $vertice)
			{
				# code...
				$yRunningTotal += $vertice->y;
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
