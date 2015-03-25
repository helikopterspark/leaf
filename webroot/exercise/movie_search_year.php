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
$dsn      = 'mysql:host=localhost;dbname=Movie;';
//$login    = 'acronym';
//$password = 'password';
$login = 'root';
$password = 'root';
$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
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

// Sök år =========================================================================================================
$year1 = isset($_GET['year1']) && !empty($_GET['year1']) ? strip_tags($_GET['year1']) : null;
$year2 = isset($_GET['year2']) && !empty($_GET['year2']) ? strip_tags($_GET['year2']) : null;

if($year1 && $year2) {
  $sql = "SELECT * FROM Movie WHERE year >= ? AND year <= ?;";
  $params = array(
    $year1,
    $year2,
  );  
} 
elseif($year1) {
  $sql = "SELECT * FROM Movie WHERE year >= ?;";
  $params = array(
    $year1,
  );  
} 
elseif($year2) {
  $sql = "SELECT * FROM Movie WHERE year <= ?;";
  $params = array(
    $year2,
  );  
} else {
  // prepare SQL to show all
	// Do SELECT from a table
	$sql = "SELECT * FROM Movie;";
	$params = null;
}
/*
$sth = $pdo->prepare($sql);
$sth->execute($params);
$res = $sth->fetchAll();
*/
$res = $db->ExecuteSelectQueryAndFetchAll($sql, $params);

// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";
}
// =================================================================================================================

$paramsPrint = htmlentities(print_r($params, 1));

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Sök titel i filmdatabasen";

$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>
<form>
<fieldset>
<legend>Sök</legend>
<p><label>Skapad mellan åren: 
    <input type='text' name='year1' value='{$year1}'/>
    - 
    <input type='text' name='year2' value='{$year2}'/>
  </label>
</p>
<p><input type='submit' name='submit' value='Sök'/></p>
<p><a href='?'>Visa alla</a></p>
</fieldset>
</form>
<p>Resultatet från SQL-frågan:</p>
<p><code>{$sql}</code></p>
<p><code>{$paramsPrint}</code></p>
<table>
{$tr}
</table>
EOD;

// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);