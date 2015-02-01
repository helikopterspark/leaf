<?php 
/**
 * This is a Leaf pagecontroller.
 *
 */
// Include the essential config-file which also creates the $leaf variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "404";
$leaf['header'] = "";
$leaf['main'] = "This is a Leaf 404. Document is not here.";
$leaf['footer'] = "";

// Send the 404 header 
header("HTTP/1.0 404 Not Found");

// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);