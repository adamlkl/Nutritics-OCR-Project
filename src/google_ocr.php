<?php
//require 'vendor/autoload.php';
# Includes the autoloader for libraries installed with composer
require __DIR__ . '/../vendor/autoload.php';
# Imports the Google Cloud client library
use Google\Cloud\Vision\VisionClient;

// function render() {
// 	header('Content-type: application/json');


// 	# Your Google Cloud Platform project ID
// 	$projectId = 'glass-arcana-196422';

// 	# Instantiates a client
// 	$vision = new VisionClient([
// 	    'projectId' => $projectId
// 	]);

// 	# The name of the image file to annotate
// 	$fileName = '/app/tests/testdata/images/noodles.jpg';

// 	# Prepare the image to be annotated
// 	$image = $vision->image(fopen($fileName, 'r'), [
// 	    'TEXT_DETECTION'
// 	]);

// 	# Performs label detection on the image file
// 	$result = $vision->annotate($image);

// 	print_r(json_encode($result->info()));
// }

// function 

function getOCRResponseJSON($image_resource) {
	# Your Google Cloud Platform project ID
	$projectId = $_ENV["GOOGLE_PROJECT_ID"];

	# Instantiates a client
	$vision = new VisionClient([
	    'projectId' => $projectId
	]);

	# Prepare the image to be annotated
	$image = $vision->image($image_resource, [
	    'TEXT_DETECTION'
	]);

	# Performs label detection on the image file
	$result = $vision->annotate($image);

	return json_encode($result->info());
}
?>