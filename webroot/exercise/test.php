<?php
/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');
include (__DIR__ . '/../src/CDatabase/CDatabase.php');
$leaf['stylesheets'][] = 'css/table.css';

// 1
$db = new CDatabase($leaf['database']);

// 2: Metoden ExecuteSelectQueryAndFetchAll()
// 2.1: Parametrar är: en SQL-fråga, parametrar till frågan som ersätter ? (kan vara en söksträng),
// true eller false huruvida debug ska skriva ut sql-frågan, fetchStyle för att ange innehållet 
// i den returnerade arrayen.
// 2.2: SQL-frågan måste anges, resten är optionella
// 2.3: Metoden returnerar en array med resultatet av SQL-frågan.

// 3
$qry = "SELECT * FROM Movie;";
// 4
$res = $db->ExecuteSelectQueryAndFetchAll($qry);
// 5
dump($res);
// 5.1: Fem filmer ligger i tabellen.
// 5.2: Id på $res[3] är 4.

// 6
$html6 = "<tr><th>Övning 6: Titel</th></tr>";
foreach ($res as $key => $value) {
	$html6 .= "<tr><td>{$value->title}</td></tr>";
}

// 7: Läsa om RowCount()

// 8
$html8 = "Övning 8: Antal påverkade rader är " . $db->RowCount() . " st";
// 8.1: Anropet till metoden returnerar 5
// 8.2: Siffran refererar till antalet rader som påverkades av senaste SQL-frågan.

// 9
// 9.1: Parametrar är: en SQL-fråga, parametrar till frågan som ersätter ? (den data som ska läggas till,
// ändras eller raderas), true eller false huruvida debug ska skriva ut sql-frågan.
// 9.2: SQL-frågan och parametrar till ? måste vara med.
// 9.3: Metoden returnerar Boolean, true eller false om frågan gick att köra eller ej.

// 10
$qry = 'INSERT INTO Movie (title, YEAR) VALUES (?, ?)';
// 11
$params = array('Rambo', 1982);
// 12
$res = $db->ExecuteQuery($qry, $params);
// 13
dump($res);
$html13 = var_dump($res);
// 13.1: 1, TRUE returnerades.
// 13.2: 1 == TRUE, vilket innebär att INSERT-frågan lyckades.

// 14: LastInsertId() returnerar ID på senast inlagda rad i tabellen.

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "CDatabase Övning";

$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>
<table>
{$html6}
</table>
{$html8}
{$html13}
EOD;

// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);