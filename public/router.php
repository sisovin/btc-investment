<?php
// Simple router for PHP built-in server
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route all requests to index.php
$_GET['_url'] = $path;
require_once __DIR__ . '/index.php';