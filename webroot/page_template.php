<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');


// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Hello, World!";

$leaf['main'] = <<<EOD
        <h1>{$leaf['title']}</h1>
        <p>Det här är en exempelsida.</p>
EOD;

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);