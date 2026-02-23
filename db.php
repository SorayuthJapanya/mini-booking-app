<?php
// Load environment variables from .env file
if (file_exists(__DIR__ . '/.env')) {
    $env_file = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($env_file as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Get database configuration from environment variables or use defaults
$host = $_ENV['DB_HOST'] ?? 'localhost';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';
$database = $_ENV['DB_NAME'] ?? 'mini-booking-app';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=$charset", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
