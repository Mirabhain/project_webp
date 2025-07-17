
<?php
session_start();
require '../db.php';
require '../auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $user = findUserByUsername($pdo, $username);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: /project%20webp/admin/admin_index.php");
        } else {
            header("Location: /project%20webp/index.html");
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

