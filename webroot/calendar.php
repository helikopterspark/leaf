<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

$leaf['stylesheets'][] = 'css/calendar.css'; 

// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Kalender";

if (isset($_GET['year']) && isset($_GET['month'])) {
	$year = $_GET['year'];
	$month = $_GET['month'];
	$calendar = new CCalendar($month, $year);
} else {
	$calendar = new CCalendar(date("n"), date("Y"));
	//$_SESSION['calendar'] = $calendar;
}

$leaf['main'] = $calendar->ShowCalendar();

include(LEAF_THEME_PATH);
