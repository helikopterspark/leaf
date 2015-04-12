<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

$user = new CUser($leaf['database']);

// Check if user and password is okey
if (isset($_POST['login'])) {
    $user->Login($_POST['acronym'], $_POST['password']);
    header('Location: login.php');
}

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Login";

if ($user->IsAuthenticated()) {
    $output = "Du är inloggad som: {$user->GetAcronym()} ({$user->GetName()})";
    $leaf['main'] = <<<EOD
	<h1>{$leaf['title']}</h1>
	<output><b>{$output}</b></output>
	<p><a href='logout.php'>Gå till utloggning</a></p>
	<p><a href='status.php'>Inloggningsstatus</a></p>
EOD;
} else {
    $leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Login</legend>
  <p><em>Du kan logga in med doe:doe eller admin:admin.</em></p>
  <p><label>Användare:<br/><input type='text' name='acronym' value=''/></label></p>
  <p><label>Lösenord:<br/><input type='password' name='password' value=''/></label></p>
  <p><input type='submit' name='login' value='Login'/></p>
  </fieldset>
</form>

EOD;
}

// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);
