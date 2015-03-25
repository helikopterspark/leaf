<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

/*
// Restore the database to its original settings BTH server
$sql      = 'movie.sql';
$mysql    = '/usr/local/bin/mysql';
$host     = 'localhost';
$login    = 'acronym';
$password = 'password';
$output = null;
*/

// Restore the database to its original settings local
$sql      = 'movie.sql';
$mysql    = '/Applications/XAMPP/xamppfiles/bin/mysql';
$host     = 'localhost';
$login    = 'root';
$password = 'root';
$output = null;
 
if(isset($_POST['restore']) || isset($_GET['restore'])) {
  $cmd = "$mysql -h{$host} -u{$login} -p{$password} < $sql 2>&1";
  $res = exec($cmd);
  $output = "<p>Databasen är återställd via kommandot<br/><code>{$cmd}</code></p><p>{$res}</p>";
}

// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Återställ databasen";

$leaf['main'] = <<<EOD
        <h1>{$leaf['title']}</h1>
        <form method=post>
		<input type=submit name=restore value='Återställ databasen'/>
		<output>{$output}</output>
		</form>
EOD;

include(LEAF_THEME_PATH);