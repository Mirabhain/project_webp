<?php
/*
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid login. <a href='login.html'>Try again</a>";
    }
}
    */

session_start();
require 'db.php';
require 'auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $user = findUserByUsername($pdo, $username);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        header("Location: index.html");
        exit(); 
    } else {
        echo "Invalid login. <a href='login.html'>Try again</a>";
    }
}

?>

