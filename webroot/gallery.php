<?php
/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

$leaf['stylesheets'][] = 'css/breadcrumb.css';
$leaf['stylesheets'][] = 'css/figure.css';
$leaf['stylesheets'][] = 'css/gallery.css';

// Define the basedir for the gallery
define('GALLERY_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'img');
define('GALLERY_BASEURL', '');

$cgallery = new CGallery();
$breadcrumb = $cgallery->createBreadcrumb();
$gallery = $cgallery->presentImages();

$leaf['title'] = "Bildgalleri";
$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>

$breadcrumb

$gallery

EOD;

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);