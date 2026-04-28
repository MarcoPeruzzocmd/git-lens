<?php
$envFile = __DIR__ . '/../.env';

if (file_exists($envFile)) {
    foreach (file($envFile) as $line) {
        $line = trim($line);
        if ($line && !str_starts_with($line, '#')) {
            putenv($line);
        }
    }
}