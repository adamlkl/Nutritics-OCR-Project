<?php

define("TEST_DATA_DIRECTORY", __DIR__ . '/../../tests/testdata');
define("TEST_IMAGES_DIRECTORY", TEST_DATA_DIRECTORY . '/images');
define("TEST_RESPONSES_DIRECTORY", TEST_DATA_DIRECTORY . '/responses');

function findTestImages() {
	return glob(TEST_IMAGES_DIRECTORY . '/*.jpg');
}

print_r(findTestImages());
?>