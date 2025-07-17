<?php
session_start();
require '../db.php';
require '../auth.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: admin_login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Create or Update
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (isset($_POST['update_id'])) {
        $id = $_POST['update_id'];
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET username=?, password=?, role=? WHERE id=?");
            $stmt->execute([$username, $hashed, $role, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET username=?, role=? WHERE id=?");
            $stmt->execute([$username, $role, $id]);
        }
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashed, $role]);
    }
    header("Location: users.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: users.php");
    exit();
}

$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #ffc9dd; /* Pink background */
            color: #4a2b2b;
            justify-content: center;
            
        }
        table {
            width: 70%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #fff;
            justify-content: justify;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        form {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccc;
        }
        input, select {
            padding: 8px;
            margin: 5px;
        }
        button {
            padding: 10px 15px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Manage Users</h2>

    <table>
        <tr>
            <th>ID</th><th>Username</th><th>Role</th><th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= $user['role'] ?></td>
            <td>
                <a href="?edit=<?= $user['id'] ?>">Edit</a> |
                <a href="?delete=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php 
    $editUser = null;
    if (isset($_GET['edit'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_GET['edit']]);
        $editUser = $stmt->fetch();
    }
    ?>

    <form method="POST">
        <h3><?= $editUser ? "Edit User" : "Add New User" ?></h3>
        <input type="text" name="username" placeholder="Username" value="<?= $editUser['username'] ?? '' ?>" required>
        <input type="password" name="password" placeholder="New Password (leave blank to keep same)">
        <select name="role" required>
            <option value="user" <?= (isset($editUser) && $editUser['role'] == 'user') ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= (isset($editUser) && $editUser['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
        </select>
        <?php if ($editUser): ?>
            <input type="hidden" name="update_id" value="<?= $editUser['id'] ?>">
        <?php endif; ?>
        <br>
        <button type="submit"><?= $editUser ? "Update" : "Create" ?></button>
    </form>
</body>
</html>
