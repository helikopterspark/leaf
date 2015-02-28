<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential condig-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

// Define what to include to make the plugin to work
$leaf['stylesheets'][] = 'css/slideshow.css';
$leaf['javascript_include'][] = 'js/slideshow.js';

// Do it and store it all in variables in the Leaf container
$leaf['title'] = "Om mig";

$leaf['main'] = <<<EOD
        <div id="slideshow" class='slideshow' data-host="" data-path="img/koenigsee/" data-images='["koenigsee-1.jpg", "koenigsee-2.jpg", "koenigsee-3.jpg", "koenigsee-4.jpg"]'>
<img src='img/koenigsee/koenigsee-3.jpg' width='960' height='180' alt='Königsee'/>
</div>
        <article>
        <h1>Om mig</h1>
        <div class='article_text'>
        <p>Jag heter Carl och bor i Linköping. Jag har jobbat som teknikinformatör i IT-branschen i drygt 15 år och har då självfallet kommit i kontakt med HTML/CSS och även XML och SGML. Jag har en fil. kand. i engelska sedan tidigare och har läst flertalet kurser inom systemvetenskap på 90-talet.</p>
            <p>Nu fräschar jag upp mina programmeringskunskaper igen och har under det gångna året läst C++, Objective-C och iOS-utveckling. Min första iOS-app, en internetradio-spelare, kommer att publiceras i App Store inom kort. Dessutom läser jag detta kurspaket i webbprogrammering med PHP.</p>
        </div>
        {$leaf['byline']}
</article>
EOD;

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);
