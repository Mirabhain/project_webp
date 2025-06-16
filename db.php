<?php
$host = 'sql113.infinityfree.com';
$db   = 'if0_39207330_hunger_finder';
$user = 'if0_39207330';     // Change if needed
$pass = 'capy2025';         // Change if password is set
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
   echo "DB connection failed: " . $e->getMessage();
    exit();
}
?>
