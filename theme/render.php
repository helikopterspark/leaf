<?php

/**
 * Render content to theme
 * 
 */
// Extract the data array to variables for easier access in the template files.
extract($leaf);

// Include the template function
include (__DIR__ . '/functions.php');

// Include the template file
include (__DIR__ . '/index.tpl.php');
