<?php

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