<?php

/**
 * Theme-related functions
 * 
 */

/**
 * Get title for the webpage by concatenating page specific title with site-wide title.
 * 
 * @param string $title for this page.
 * @return string/null whether the favicon is defined or not.
 */
function get_title($title) {
    global $leaf;
    return $title . (isset($leaf['title_append']) ? $leaf['title_append'] : null);
}

/**
 * Set style for selected navbar item
 * 
 * @param string $items
 * @return string
 */
function modifyNavbar($items) {
    //$ref = isset($_GET['p']) && isset($items[$_GET['p']]) ? $_GET['p'] : null;
    $ref = basename($_SERVER['SCRIPT_FILENAME']);
    if ($ref) {
        $items[$ref]['class'] .= 'selected';
    }
    return $items;
}