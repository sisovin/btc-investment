<?php

/**
 * Application Bootstrap
 *
 * This file initializes the application and handles all incoming requests.
 * It sets up the core components and dispatches requests to the appropriate controllers.
 */

// Define application paths (only if not already defined)
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
    define('APP_PATH', ROOT_PATH . '/app');
    define('CONFIG_PATH', ROOT_PATH . '/config');
    define('PUBLIC_PATH', ROOT_PATH . '/public');
    define('RESOURCES_PATH', ROOT_PATH . '/resources');
    define('STORAGE_PATH', ROOT_PATH . '/storage');
}

// Load composer autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Load environment variables
require_once CONFIG_PATH . '/env.php';
\App\Config\EnvLoader::load();

// Load helper functions
require_once APP_PATH . '/Core/helpers.php';

// Load application constants
require_once CONFIG_PATH . '/constants.php';

// Start session
session_start();

// Initialize authentication
\App\Core\Auth::init();

// Initialize core components
try {
    // Database connection
    $db = App\Core\Database::getInstance();
    
    // Initialize model database connection
    App\Core\Model::setDatabase($db);

    // Request and Response objects
    $request = new App\Core\Request();
    $response = new App\Core\Response();

    // Store request instance for global access
    App\Core\Request::setInstance($request);

    // Load routes
    require_once APP_PATH . '/routes.php';

    // Dispatch the request
    App\Core\Router::dispatch($request, $response);

} catch (Exception $e) {
    // Handle application errors
    if (APP_DEBUG) {
        // In debug mode, show detailed error for development
        http_response_code(500);
        echo "<!DOCTYPE html><html><head><title>Application Error</title></head><body>";
        echo "<h1>Application Error</h1>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
        echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
        echo "</body></html>";
    } else {
        // In production, show generic error page
        http_response_code(500);
        echo "<!DOCTYPE html><html><head><title>Server Error</title></head><body>";
        echo "<h1>500 - Internal Server Error</h1>";
        echo "<p>Something went wrong. Please try again later.</p>";
        echo "</body></html>";
    }
}