<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';
require 'auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];  // Don't hash here!

    if (findUserByUsername($pdo, $username)) {
        header("Location: signup.html?status=exists");
        exit();
    }

    if (registerUser($pdo, $username, $password)) {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = "user";

        header("Location: login.php?status=success");
        exit();
    } else {
        header("Location: signup.html?status=failed");
        exit();
    }
}
?>
