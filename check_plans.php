<?php
require 'vendor/autoload.php';
require 'app/Core/helpers.php';
require 'app/Core/Database.php';
require 'config/env.php';
App\Config\EnvLoader::load();
$db = App\Core\Database::getInstance();
App\Core\Model::setDatabase($db);
require 'app/Models/Plan.php';
$plans = App\Models\Plan::getActive();
echo 'Active plans found: ' . count($plans) . PHP_EOL;
foreach ($plans as $plan) {
    echo $plan['name'] . ' - Status: ' . $plan['status'] . PHP_EOL;
}
?>