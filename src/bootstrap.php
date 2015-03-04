<?php

/**
 * Bootstrapping functions, essential and needed for Leaf to work together with some common helpers
 * 
 */

/**
 * Default exception handler
 * 
 */
function myExceptionHandler($exception) {
    echo "Leaf: Uncaught exception: <p>" . $exception->getMessage() . "</p><pre>" . $exception->getTraceAsString(), "</pre>";
}

set_exception_handler('myExceptionHandler');

/**
 * Autoloader for classes
 * 
 */
function myAutoloader($class) {
    $path = LEAF_INSTALL_PATH . "/src/{$class}/{$class}.php";
    if (is_file($path)) {
        include($path);
    } else {
        throw new Exception("Classfile '{$class}' does not exist.");
    }
}

spl_autoload_register('myAutoloader');

/**
 * anropa funktionen så här
 * dump($_SERVER);
 */
function dump($array) {
    echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}

// -------------------------------------------------------------------------------------------
//
// Function to open and read a directory, return its content as an array.
//
// $aPath: A path to the directory to scan for files.
//
//  http://php.net/manual/en/function.is-dir.php
//  http://php.net/manual/en/function.opendir.php
//  http://php.net/manual/en/function.readdir.php
//  http://php.net/manual/en/function.is-file.php
//  http://php.net/manual/en/function.closedir.php
//  http://php.net/manual/en/function.sort.php
//
function readDirectory($aPath) {
    $list = Array();
    if (is_dir($aPath)) {
        if ($dh = opendir($aPath)) {
            while (($file = readdir($dh)) !== false) {
                if (is_file("$aPath/$file") && $file != '.htaccess') {
                    $list[$file] = "$file";
                }
            }
            closedir($dh);
        }
    }
    sort($list, SORT_STRING);
    return $list;
}

// -------------------------------------------------------------------------------------------
// Kolla om fil finns, returnera innehåll eller felmeddelande

function getFileContents($aFileName) {
    if (is_readable($aFileName)) {
        return file_get_contents($aFileName);
    } else {
        return "Filen finns ej.";
    }
}