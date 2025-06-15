<?php
/*
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Secure

    // Check if username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        echo "Username already exists. <a href='signup.html'>Try another</a>";
        exit();
    }

    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    $_SESSION["logged_in"] = true;
    $_SESSION["username"] = $username;
    header("Location: index.php");
    exit();
}*/

session_start();
require 'db.php';
require 'auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (findUserByUsername($pdo, $username)) {
        echo "Username already exists. <a href='signup.html'>Try another</a>";
        exit();
    }

    if (registerUser($pdo, $username, $password)) {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        header("Location: login.html");
        exit();
    } else {
        echo "Signup failed. Try again later.";
    }
}