<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

$ccontent = new CContent($leaf['database']);
$list = $ccontent->listDBContent();

// Do it and store it all in variables in the Leaf container
//$leaf['debug'] = $ccontent->getDBDump();
$leaf['title'] = "Visa allt innehåll";

$leaf['main'] = <<<EOD
        <h1>{$leaf['title']}</h1>
        <p>Här är en lista på allt innehåll i databasen.</p>
        {$list}
        <p><a href="blog.php">Visa alla bloggposter</a></p>
        <p><a href="edit.php">Skapa nytt inlägg</a></p>
EOD;

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);