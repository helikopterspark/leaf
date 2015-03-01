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

$p = null;
if (isset($_GET['p'])) {
	$p = $_GET['p'];
}

if($p == 'reset') {
	unset($_SESSION['calendar']);
}

if (isset($_SESSION['calendar'])) {
	$calendar = $_SESSION['calendar'];
	if ($p == 'nextM') {
		$calendar->GotoNext();
	} else if($p == 'prevM') {
		$calendar->GotoPrev();
	}
} else {
	$calendar = new CCalendar(date("n"), date("Y"));
	$_SESSION['calendar'] = $calendar;
}

$leaf['calendar'] = $calendar->ShowCalendar();

$leaf['main'] = <<<EOD
        {$leaf['calendar']}
EOD;

include(LEAF_THEME_PATH);
