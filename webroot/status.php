<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

$user = new CUser($leaf['database']);

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Inloggningsstatus";

if ($user->IsAuthenticated()) {
    $output = "Du är inloggad som: {$user->GetAcronym()} ({$user->GetName()})";
    $link = '<p><a href="logout.php">Gå till utloggning</a></p>';
} else {
    $output = "Du är INTE inloggad.";
    $link = '<p><a href="login.php">Gå till inloggning</a></p>';
}

$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>

<div>
  <output><b>{$output}</b></output>
  {$link}
 </div>

EOD;

// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);
