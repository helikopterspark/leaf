<?php
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