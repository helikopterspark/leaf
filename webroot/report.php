<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

$creport = new CReport($leaf['database']);
$reportcontent = $creport->getReportContent();
$aside = $creport->getLinklist('report', 'html');

// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Redovisning";

$leaf['main'] = <<<EOD
        <h1>{$leaf['title']}</h1>
        <aside id="report">
        {$aside}
        <hr style="border: 1px dashed #555;">
        <ul><li><a href='report.php'>Visa alla</a></li></ul>
        </aside>
        <article>
        {$reportcontent}
        {$leaf['byline']}
        </article>
EOD;

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);
