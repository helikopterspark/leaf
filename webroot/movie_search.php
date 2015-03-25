<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');
$leaf['stylesheets'][] = 'css/table.css';

$moviesearch = new CMovieSearch($leaf['database']);
$searchform = $moviesearch->ShowSearchForm();
$searchresults = $moviesearch->PreparePerformSQLquery();

$htmltable = new CHTMLTable();
$resulttable = $htmltable->GetHTMLTable($searchresults);

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Sök i filmdatabasen";

$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>
{$searchform}
{$resulttable}
EOD;

// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);
