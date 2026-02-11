<?php

/**
 * PHP Built-in Server Router
 *
 * This file routes all requests to the main index.php file
 * for proper MVC routing.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If the requested file exists and is not a PHP file, serve it directly
if ($uri !== '/' && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri) && pathinfo($uri, PATHINFO_EXTENSION) !== 'php') {
    return false;
}

// Route everything else to index.php
require_once __DIR__ . '/index.php';