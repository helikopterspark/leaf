<?php
/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');
$leaf['stylesheets'][] = 'css/table.css';
$leaf['stylesheets'][] = '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css';

$db = new CDatabase($leaf['database']);
// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);

// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th></th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td style='text-align:center;' class='menu'><a href='movie_edit.php?id={$val->id}'><i class='icon-edit'></i></a></td></tr>";
}

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Välj och uppdatera info om film";

$sqlDebug = $db->Dump();

$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>
<table>
{$tr}
</table>
<div class=debug>{$sqlDebug}</div>
EOD;

// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);