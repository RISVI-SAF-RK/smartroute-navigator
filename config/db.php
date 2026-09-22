<?php

$localEnv = __DIR__ . '/local_env.php';

if (file_exists($localEnv)) {
    require_once $localEnv;
}

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_NAME');

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database,
    (int)$port
);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>