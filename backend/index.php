<?php
foreach (file(__DIR__ . '/.env') as $line) {
    $line = trim($line);
    if ($line && !str_starts_with($line, '#')) {
        putenv($line);
    }
}

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Content-Type: application/json");

$route = $_GET['route'] ?? '';

match($route) {
    'commits' => require __DIR__ . '/commits.php',
    default   => http_response_code(404)
};
echo "funcionando";