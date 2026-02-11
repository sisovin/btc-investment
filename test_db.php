<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=btc_investment', 'root', 'root');
    echo 'Connection successful' . PHP_EOL;

    $stmt = $pdo->query("SELECT COUNT(*) as count FROM plans");
    $result = $stmt->fetch();
    echo 'Plans count: ' . $result['count'] . PHP_EOL;

    if ($result['count'] > 0) {
        $stmt = $pdo->query("SELECT * FROM plans LIMIT 3");
        $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo 'Sample plans:' . PHP_EOL;
        foreach ($plans as $plan) {
            echo '- ' . $plan['name'] . ' ($' . $plan['min_amount'] . ' - $' . $plan['max_amount'] . ')' . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}