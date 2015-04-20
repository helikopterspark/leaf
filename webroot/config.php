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
//session_cache_limiter('private_no_expire');
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
        <footer><span class='sidefooter'>Copyright (c) 2015 Carl Ramsell | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a>
        | <img src='img/Icon-Small.png' height='15' width='15' alt='App icon'/>
        <a href='https://itunes.apple.com/se/app/bitzucker-radio-free-streaming/id968115492'>
Bitzucker Radio för iPhone
</a>
        </span>
        </footer>
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
 * Settings for the database.
 *
 */

define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
$leaf['database']['dsn'] = 'mysql:host=localhost;dbname=Kmom05oophp;';
//$leaf['database']['dsn'] = 'mysql:host=localhost;dbname=Movie;';
/*
define('DB_USER', 'carb14');
define('DB_PASSWORD', '80YD}3Pl');
$leaf['database']['dsn'] = 'mysql:host=blu-ray.student.bth.se;dbname=' . DB_USER . ';';
*/
$leaf['database']['username'] = DB_USER;
$leaf['database']['password'] = DB_PASSWORD;
$leaf['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

/**
 * Nav menu
 * 
 */
$ccontent = new CContent($leaf['database']);
$blogmenu = $ccontent->getNavbarArray('post');
$pagemenu = $ccontent->getNavbarArray('page');

$leaf['menu'] = array(
    'class' => 'navbar',
    //'callback' => 'modifyNavbar',
    'items' => array(
        'home' => array('text' => 'Hem', 'url' => 'home.php', 'title' => 'Hem'),
        'dice' => array('text' => 'Tärning 100', 'url' => 'diceplay.php', 'title' => 'Tärning 100'),
        'calendar' => array('text' => 'Kalender', 'url' => 'calendar.php', 'title' => 'Kalender'),
        'movies' => array('text' => 'FilmDB', 'url' => 'movie_search.php', 'title' => 'FilmDB'),
        'content' => array('text' => 'TextDB', 'url' => 'view.php', 'title' => 'TextDB',
            'submenu' => array(
                'class' => 'submenu',
                'items' => array(
                    'edit' => array('text' => 'Ny/Redigera', 'url' => 'edit.php', 'title' => 'Ny/Redigera'),
                    'reset' => array('text' => 'Återställ', 'url' => 'reset.php', 'title' => 'Återställ'),
                    'textfilter' => array('text' => 'Textfilter', 'url' => 'textfilter.php', 'title' => 'Textfilter'),
                ),
            ),
        ),
        'blog' => array('text' => 'Blogg', 'url' => 'blog.php', 'title' => 'Blogg',
            'submenu' => array(
                'class' => 'submenu',
                'items' => $blogmenu
                ),
            ),
        'page' => array('text' => 'Sidor', 'url' => 'page.php', 'title' => 'Sidor',
            'submenu' => array(
                'class' => 'submenu',
                'items' => $pagemenu
                ),
            ),
        'image' => array('text' => 'Bilder', 'url' => 'img_test.php', 'title' => 'Bilder'),
        'gallery' => array('text' => 'Galleri', 'url' => 'gallery.php', 'title' => 'Galleri'),
        'report' => array('text' => 'Redovisning', 'url' => 'report.php', 'title' => 'Redovisning'),
        'source' => array('text' => 'Källkod', 'url' => 'source.php', 'title' => 'Källkod'),
        'login' => array('text' => 'Login', 'url' => 'login.php', 'title' => 'Login',
            'submenu' => array(
                'class' => 'submenu',
                'items' => array(
                    'logout' => array('text' => 'Logout', 'url' => 'logout.php', 'title' => 'Logout'),
                    'status' => array('text' => 'Status', 'url' => 'status.php', 'title' => 'Status'),
                ),
            ),
        ),
    ),
    // This is the callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if (basename($_SERVER['SCRIPT_FILENAME']) == $url || basename($_SERVER['REQUEST_URI']) == $url) {
            return true;
        }
    }
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
