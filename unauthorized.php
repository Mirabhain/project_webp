<?php
require 'db.php';
$pass = password_hash("adminpassword", PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
$stmt->execute(['adminusername', $pass]);
echo "Admin created!";
?>
