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

	$object = findObject("Fat", $response);
	echo($object->description);
	$topLeft = $object->boundingPoly->vertices[0]->x;
	
	echo($topLeft);
	
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