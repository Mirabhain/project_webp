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
    
<?php
session_start();
require 'db.php';
require 'auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    
    $user = findUserByUsername($pdo, $username);
    
    if ($user && password_verify($password, $user["password"])) {
        // Set session variables
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $user["username"];
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];

        // Redirect based on role
        if ($user["role"] === "admin") {
            header("Location: admin/admin_index.php");
            exit();
        } else {
            header("Location:index.html");
            exit();
        }

    } else {
        // Invalid credentials
        header("Location: login.html?status=failed");
        exit();
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
        $_SESSION["role"] = $user["role"];

        if ($user["role"] === "admin") {
            header("Location: /project%20webp/admin/admin_index.php");  // Admin dashboard
        } else {
            header("Location: index.html");  // User homepage
        }
        exit();
    } else {
        echo "Invalid username or password. <a href='login.html'>Try again</a>";
    }
}
?>
