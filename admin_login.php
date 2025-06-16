<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../db.php';
require '../auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $user = findUserByUsername($pdo, $username);

    if ($user) {
        if (password_verify($password, $user["password"])) {
            if ($user["role"] === "admin") {
                // Set session variables
                $_SESSION["logged_in"] = true;
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];
                $_SESSION["user_id"] = $user["id"];
                
                // Redirect to admin dashboard
                header("Location: admin_index.php");
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>You are not an admin. <a href='../login.html'>Login as user</a></p>";
            }
        } else {
            echo "<p style='color:red; text-align:center;'>Invalid username or password. <a href='admin_login.html'>Try again</a></p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid username or password. <a href='admin_login.html'>Try again</a></p>";
    }
}
?>

