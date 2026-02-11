<?php
require_once 'vendor/autoload.php';
require_once 'app/routes.php';
$routes = App\Core\Router::getRoutes();
foreach($routes as $route) {
    if($route['path'] === '/') {
        echo 'Path: ' . $route['path'] . ', Pattern: ' . $route['pattern'] . PHP_EOL;
        break;
    }
}
echo 'URI to test: ' . rtrim(parse_url('http://localhost:8000/', PHP_URL_PATH), '/') . PHP_EOL;