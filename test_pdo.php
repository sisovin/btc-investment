<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=btc_investment', 'root', 'root');
    echo 'Success with password root';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}