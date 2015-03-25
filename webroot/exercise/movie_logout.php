<?php
/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

// Check if user is authenticated.
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
 
if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
}
else {
  $output = "Du är INTE inloggad.";
}

// Logout the user
if(isset($_POST['logout'])) {
  unset($_SESSION['user']);
  header('Location: movie_logout.php');
}
// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Logout";

$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Logout</legend>
  <p><input type='submit' name='logout' value='Logout'/></p>
  <p><a href='movie_login.php'>Login</a></p>
  <output><b>{$output}</b></output>
  </fieldset>
</form>

EOD;



// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);