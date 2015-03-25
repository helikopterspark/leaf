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

// Sök genre ========================================================================================================
// Get parameters for sorting
$genre = isset($_GET['genre']) ? strip_tags($_GET['genre']) : null;

// Get active genres
$sql = "SELECT DISTINCT G.name
	FROM Genre AS G
	INNER JOIN Movie2Genre AS M2G
	ON G.id = M2G.idGenre;";
/*
$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();
*/
$res = $db->ExecuteSelectQueryAndFetchAll($sql);

$list = null;
foreach ($res as $key => $value) {
	$list .= "<a href='?genre={$value->name}'>{$value->name}</a> ";
}

if ($genre) {
    $sql = "SELECT 
	M.*,
	G.name AS genre
	FROM Movie AS M
	LEFT OUTER JOIN Movie2Genre AS M2G
	ON M.id = M2G.idMovie
	LEFT OUTER JOIN Genre AS G
	ON M2G.idGenre = G.id
	WHERE G.name = ?
	;";
    $params = array($genre,);
} else {
	$sql = "SELECT * FROM VMovie;";
    $params = null;
}
/*
$sth = $pdo->prepare($sql);
$sth->execute($params);
$res = $sth->fetchAll();
*/
$res = $db->ExecuteSelectQueryAndFetchAll($sql, $params);

// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th>Genre</th></tr>";
foreach ($res AS $key => $val) {
    $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
}
// =================================================================================================================

$paramsPrint = htmlentities(print_r($params, 1));

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Sök film per genre";

$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>
<form>
<fieldset>
<legend>Sök</legend>
<p><label>Välj genre: 
    {$list}
  </label>
</p>
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
