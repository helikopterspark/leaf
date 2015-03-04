<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');
$path = (__DIR__) . '/reports/';

$leaf['reports'] = null;
$reportList = array();
$reportFiles = readDirectory($path);
foreach ($reportFiles as $reportFile) {
	include($path . '/' . $reportFile);
	$reportList[] = basename($reportFile, ".php");
}

$html = '<ul>';
foreach ($reportList as $reportLink) {
	$html .= '<li><a href="#' . $reportLink . '">' . $reportLink . '</a></li>';
}
$html .= '</ul>';
// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Redovisning";

$leaf['main'] = <<<EOD
	<h1>Redovisning</h1>
        <aside id="report">
        	{$html}
        </aside>
        <article>
        {$leaf['reports']}
        {$leaf['byline']}
        </article>
EOD;

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);
