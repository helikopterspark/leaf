<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Hello, World!";
/*
$leaf['header'] = <<<EOD
        <img class='sitelogo' src='img/leaflogo.png' alt='Leaf logo' />
        <span class='sitetitle'>Leaf webtemplate</span>
        <span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>
EOD;
*/
$leaf['main'] = <<<EOD
        <h1>Hej Världen</h1>
        <p>Detta är en exempelsida som visar hur Leaf ser ut och fungerar.</p>
EOD;
/*
$leaf['footer'] = <<<EOD
        <footer><span class='sidefooter'>Copyright (c) Carl Ramsell | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span></footer>
EOD;
*/
// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);