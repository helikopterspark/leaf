<?php

/**
 * Config-file for Leaf. Change settings here to affect installation
 * 
 */
/**
 * Set error reporting
 * 
 */
error_reporting(-1);            // Report all types of errors
ini_set('display_errors', 1);   // Display all errors
ini_set('output_buffering', 0); // Do not buffer outputs, write directly

/**
 * Define Leaf paths
 * 
 */
define('LEAF_INSTALL_PATH', __DIR__ . '/..');
define('LEAF_THEME_PATH', LEAF_INSTALL_PATH . '/theme/render.php');

/**
 * Include bootstrapping functions
 * 
 */
include(LEAF_INSTALL_PATH . '/src/bootstrap.php');

/**
 * Start the session
 * 
 */
session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();

/**
 * Create the $leaf variable
 * 
 */
$leaf = array();

/**
 * Site-wide settings
 * 
 */
$leaf['lang'] = 'sv';
$leaf['title_append'] = ' | oophp';

$leaf['header'] = <<<EOD
        <img class='sitelogo' src='img/leaflogo.png' alt='Leaf logo' />
        <span class='sitetitle'>oophp</span>
        <span class='siteslogan'>Min sida i kursen Databaser och objektorienterad PHP-programmering</span>
EOD;

$leaf['footer'] = <<<EOD
        <footer><span class='sidefooter'>Copyright (c) Carl Ramsell | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span></footer>
EOD;

$leaf['byline'] = <<<EOD
        <!-- footer byline -->
<footer class="byline">
    <figure class="left_float_with_margin">
        <img src="img/me_logo2.png" alt="Litet porträtt" height="50" width="50">
    </figure>
    <p id="byline_text">Dessa kurser kommer att vara min huvudsakliga fritidssysselsättning ett tag framöver. I övrigt tycker jag om gamla och nya datorer, böcker, film och musik.</p>
</footer>
EOD;

/**
 * Nav menu
 * 
 */
$leaf['menu'] = array(
    'class' => 'navbar',
    'callback' => 'modifyNavbar',
    'items' => array(
        'home.php' => array('text' => 'Hem', 'url' => 'home.php', 'class' => null),
        'report.php' => array('text' => 'Redovisning', 'url' => 'report.php', 'class' => null),
        'source.php' => array('text' => 'Källkod', 'url' => 'source.php', 'class' => null),
    ),
);

/**
 * Theme-related settings
 * 
 */
$leaf['stylesheets'] = array('css/style.css');
$leaf['favicon'] = 'favicon.ico';

/**
 * Settings for JavaScript
 * 
 */
$leaf['modernizr'] = 'js/modernizr.js';
$leaf['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
//$leaf['jquery'] = null; // To disable jQuery

$leaf['javascript_include'] = array();
//$leaf['javascript_include'] = array('js/main.js');  // To add extra javascript files

/**
 * Google Analytics
 * 
 */
//$leaf['google_analytics'] = 'UA-22093351-1';    // Set to null to disable Google Analytics
$leaf['google_analytics'] = null;