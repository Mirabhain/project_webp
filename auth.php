<?php //auth.php
/*
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

*/

// auth.php - Updated authentication functions
// auth.php

function findUserByUsername($pdo, $username) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return associative array
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

function registerUser($pdo, $username, $password) {
    try {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
        return $stmt->execute([$username, $passwordHash]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

function getCurrentUser($pdo) {
    if (isset($_SESSION['username'])) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$_SESSION['username']]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    return false;
}

function isAdmin() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
}

function requireAdmin() {
    if (!isAdmin()) {
        // Adjust the path depending on your project structure!
        header("Location: /project%20webp/admin/admin_login.html");
        exit();
    }
}
?>
