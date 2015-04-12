<?php
/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');
$leaf['stylesheets'][] = 'css/forms.css';

$ccontent = new CContent($leaf['database']);

// Do it and store it all in variables in the Leaf container
//$leaf['debug'] = $ccontent->getDBDump();
$leaf['title'] = "Radera inlägg";

$leaf['main'] = "<article><h1>{$leaf['title']}</h1>"
 . $ccontent->verifyDelete() . "</article>";

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);