<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');
setlocale(LC_TIME, "sv_SE.UTF-8");
// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Kalender";
$date = 'Dagens datum: ' . strftime("%A, %e, %B, %Y") . ', vecka ' . strftime("%V") . '.';
$date .= '<p>' . strftime("%B") . ' har ' . date("t") . ' dagar.</p>';

$leaf['main'] = <<<EOD
        <h1>Månadskalender</h1>
        <p>{$date}</p>
EOD;

include(LEAF_THEME_PATH);
