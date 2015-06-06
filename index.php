<?php

    // Include the DirectoryLister class
    require_once('resources/DirectoryLister.php');

    // Initialize the DirectoryLister object
    $lister = new DirectoryLister();

    // Restrict access to current directory
    ini_set('open_basedir', getcwd());

    // Return file hash
    if (isset($_GET['hash'])) {

        $hashUrl= $_GET['hash'];
        $hashUrl = ltrim($hashUrl, '/');

        // Get file hash array and JSON encode it
        $hashes = $lister->getFileHash($hashUrl);
        $data   = json_encode($hashes);

        // Return the data
        die($data);

    }
    $dir = $_SERVER['REQUEST_URI'];
    $dir = substr($dir, 1);

    // Initialize the directory array
    if (isset($dir)) {
        $dirArray = $lister->listDirectory($dir);
    } else {
        $dirArray = $lister->listDirectory('.');
    }

    // Define theme path
    if (!defined('THEMEPATH')) {
        define('THEMEPATH', $lister->getThemePath());
    }

    // Set path to theme index
    $themeIndex = $lister->getThemePath(true) . '/index.php';

    // Initialize the theme
    if (file_exists($themeIndex)) {
        include($themeIndex);
    } else {
        die('ERROR: Failed to initialize theme');
    }
