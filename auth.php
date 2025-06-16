<?php //auth.php
function findUserByUsername($pdo, $username) {
    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch();
}


function registerUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
    return $stmt->execute([$username, $password]);
}

function isLoggedIn() {
    return isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true;
}

function isAdmin() {
    return isLoggedIn() && isset($_SESSION["role"]) && $_SESSION["role"] === "admin";
}

function isUser() {
    return isLoggedIn() && isset($_SESSION["role"]) && $_SESSION["role"] === "user";
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../login.html");
        exit();
    }
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: ../unauthorized.php");
        exit();
    }
}

function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'username' => $_SESSION["username"],
            'role' => $_SESSION["role"],
            'id' => $_SESSION["user_id"]
        ];
    }
    return null;
}
?>
