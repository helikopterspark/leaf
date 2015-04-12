<?php
/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');
$leaf['stylesheets'][] = 'css/forms.css';

$ccontent = new CContent($leaf['database']);
$reset = $ccontent->resetRestoreDB();
//$leaf['debug'] = $ccontent->getDBDump();

// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Återställ databasen";

$leaf['main'] = <<<EOD
        <h1>{$leaf['title']}</h1>
        {$reset}
EOD;

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);