<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

$user = new CUser($leaf['database']);

// Logout the user
if (isset($_POST['logout'])) {
    $user->Logout();
    header('Location: logout.php');
}

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Logout";

if ($user->IsAuthenticated()) {
    $output = "Du är inloggad som: {$user->GetAcronym()} ({$user->GetName()})";
    $leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Logout</legend>
  <p><input type='submit' name='logout' value='Logout'/></p>
  <output><b>{$output}</b></output>
  </fieldset>
</form>

EOD;
} else {
    $output = "Du är INTE inloggad.";
    $leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>
<output><b>{$output}</b></output>
<p><a href='login.php'>Gå till inloggning</a></p>
EOD;
}

// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);
