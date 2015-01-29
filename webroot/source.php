<?php
/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

// Add style for csource
$leaf['stylesheets'][] = 'css/source.css';
 
// Create the object to display sourcecode
//$source = new CSource();
$source = new CSource(array('secure_dir' => '..', 'base_dir' => '..'));

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Visa källkod";
$leaf['main'] = "<h1>Visa källkod</h1>\n" . $source->View();

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);