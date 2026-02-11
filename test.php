<?php

try {
    require_once 'vendor/autoload.php';
    require_once 'config/env.php';
    \App\Config\EnvLoader::load();
    require_once 'config/constants.php';
    require_once 'app/Core/helpers.php';

    echo 'DB_PASSWORD from env: "' . getenv('DB_PASSWORD') . '"' . PHP_EOL;
    echo 'DB_PASSWORD from config: "' . env('DB_PASSWORD', 'NOT_SET') . '"' . PHP_EOL;

    // Test database config directly
    $configFile = 'config/database.php';
    if (file_exists($configFile)) {
        $config = require $configFile;
        $defaultConnection = $config['default'] ?? 'mysql';
        $connectionConfig = $config['connections'][$defaultConnection] ?? [];
        echo 'Database config password: "' . ($connectionConfig['password'] ?? 'NOT_SET') . '"' . PHP_EOL;
    }

    $db = \App\Core\Database::getInstance();
    echo 'Database connection successful!' . PHP_EOL;

    $plans = \App\Models\Plan::getActive();
    echo 'Found ' . count($plans) . ' active plans' . PHP_EOL;

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}