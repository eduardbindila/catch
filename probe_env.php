<?php
require __DIR__ . '/config/secret_loader.php';

// EN: Try to read from ENV or from secrets/<NAME> or /run/secrets/<NAME>
$items = ['APP_SECRET', 'DATABASE_URL', 'SYLVANIA_API_KEY'];

header('Content-Type: text/plain');
foreach ($items as $key) {
    $val = get_config($key, '(not set)');
    echo $key . ' = ' . $val . PHP_EOL;
}
