<?php
/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');
$leaf['stylesheets'][] = 'css/table.css';

/*
// Connect to a MySQL database using PHP PDO
$dsn = 'mysql:host=localhost;dbname=Movie;';
//$login    = 'acronym';
//$password = 'password';
$login = 'root';
$password = 'root';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
//$pdo = new PDO($dsn, $login, $password, $options);
try {
    $pdo = new PDO($dsn, $login, $password, $options);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (Exception $e) {
    //throw $e; // For debug purpose, shows all connection details
    throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
*/
$db = new CDatabase($leaf['database']);

// Sortera =========================================================================================================
// Get parameters for sorting
$orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
$order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';

// Check that incoming is valid
in_array($orderby, array('id', 'title', 'year')) or die('Check: Not valid column.');
in_array($order, array('asc', 'desc')) or die('Check: Not valid sort order.');
 
// Do SELECT from a table
$sql = "SELECT * FROM VMovie ORDER BY $orderby $order;";
/*
$sth = $pdo->prepare($sql);
$sth->execute(array($orderby, $order));
$res = $sth->fetchAll();
*/
$res = $db->ExecuteSelectQueryAndFetchAll($sql);


/**
 * Function to create links for sorting
 *
 * @param string $column the name of the database column to sort by
 * @return string with links to order by column.
 */
function orderby($column) {
  return "<span class='orderby'><a href='?orderby={$column}&order=asc'>&darr;</i></a><a href='?orderby={$column}&order=desc'>&uarr;</a></span>";
}
 
// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id " . orderby('id') . "</th><th>Bild</th><th>Titel " . orderby('title') . "</th><th>År " . orderby('year') . "</th><th>Genre</th></tr>";
foreach ($res AS $key => $val) {
    $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
}
// =================================================================================================================

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Sortera tabellens innehåll";

$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>
<p>Resultatet från SQL-frågan:</p>
<p><code>{$sql}</code></p>
<table>
{$tr}
</table>
EOD;

// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);