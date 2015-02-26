<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

if (isset($_SESSION['diceplay'])) {
    $play = $_SESSION['diceplay'];
} else {
    $play = new CPlayDice100();
    $_SESSION['diceplay'] = $play;
}
$leaf['diceplay'] = $play->PlayDice100();


// Define what to include to make the plugin to work
$leaf['stylesheets'][] = 'css/dice.css';

// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Tärningsspelet 100";

$leaf['main'] = <<<EOD
<aside id="dice100">
<h3>Instruktion</h3>
<p>I varje omgång kastar en spelare tärning tills hon väljer att stanna och spara poängen eller tills det dyker upp en 1:a och hon förlorar alla poäng som samlats in i rundan.</p>
<p>Välj först antal spelare, en eller två mänskliga spelare. Välj noll, en eller två datorspelare.</p>
<p>Klicka på Fortsätt efter en kastomgång för att låta nästa spelare kasta.</p>
<p>Klicka på Börja om för att avbryta och starta en ny spelomgång.</p>
</aside>
        <article>
        <h1>Tärningsspelet 100</h1>
        <div class='article_text'>
        <p>I tärningsspelet 100 gäller det att samla ihop poäng för att komma först till 100.</p>
        </div>
        <div style="height: 450px;">
        {$leaf['diceplay']}
        </div>
</article>
EOD;

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);
