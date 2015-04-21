<?php
/**
 * This is a PHP skript to process images using PHP GD.
 *
 */

include_once(__DIR__ . '/../src/CImage/CImage.php');
//
// Define some constant values, append slash
// Use DIRECTORY_SEPARATOR to make it work on both windows and unix.
//
define('IMG_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR);
define('CACHE_PATH', __DIR__ . '/cache/');

$image = new CImage();
$image->processImage();