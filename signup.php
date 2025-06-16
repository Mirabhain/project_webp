<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';
require 'auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    // Hash password before storing
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    if (findUserByUsername($pdo, $username)) {
        // Username exists → redirect with exists status
        header("Location: signup.html?status=exists");
        exit();
    }

    if (registerUser($pdo, $username, $password)) {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = "user";

        // Redirect to login with success status
        header("Location: login.html?status=success");
        exit();
    } else {
        // Signup failed
        header("Location: signup.html?status=failed");
        exit();
    }
}
?>
