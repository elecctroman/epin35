<?php
$config = require __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST') ?: 'localhost', getenv('DB_NAME') ?: 'maxistore');
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->exec("SET time_zone = '" . $config['timezone'] . "'");
} catch (PDOException $e) {
    if ($config['debug']) {
        throw $e;
    }
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('Database connection error.');
}

return $pdo;
