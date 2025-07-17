<?php
session_start();
require 'db.php';
require 'auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $user = findUserByUsername($pdo, $username);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $user["username"];
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];

        // Instead of immediate PHP header redirect, we can display a message + JS redirect
        if ($user["role"] === "user") {
            $redirect = "index.html";
        } else {
            $redirect = "admin/restaurant.php";
        }
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
?>

<?php if (isset($redirect)): ?>
<!DOCTYPE html>
<html>
<head>
    <title>Logging in...</title>
    <meta http-equiv="refresh" content="2;url=<?= htmlspecialchars($redirect) ?>">
</head>
<body>
    <h1>Login successful!</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>. Redirecting...</p>

    <script>
        setTimeout(function() {
            window.location.href = '<?= htmlspecialchars($redirect) ?>';
        }, 2000);
    </script>
</body>
</html>
<?php endif; ?>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
  <p style="color: green;">You have registered successfully, now log in!</p>
<?php endif; ?>

