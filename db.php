<?php
$host = 'localhost';
$db   = 'hunger_finder';
$user = 'root';  // use your local DB username
$pass = '';      // use your local DB password if any
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "DB connection failed: " . $e->getMessage();
    exit();
}
?>
