<?php //admin/index.php
session_start();
require '../db.php';
require '../auth.php';

// Ensure only admins can access this page
//requireAdmin();
//if (!isAdmin()) {
//    header("Location: unauthorized.php");
//    exit();
//}

if (!isset($_SESSION["logged_in"]) || $_SESSION["role"] !== "admin") {
    header("Location: admin_login.html");
    exit();
}

//$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #dc3545; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .nav { display: flex; gap: 15px; margin-bottom: 20px; }
        .nav a { padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .nav a:hover { background: #0056b3; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #28a745; color: white; padding: 20px; border-radius: 8px; text-align: center; }
        .recent-activity { background: #f8f9fa; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <p>Welcome back, <?php echo htmlspecialchars($currentUser["username"]); ?>! | <a href="../logout.php" style="color: #fff;">Logout</a></p>
        </div>

        <div class="nav">
            <a href="users.php">Manage Users</a>
            <a href="reports.php">View Reports</a>
            <a href="settings.php">System Settings</a>
            <a href="logs.php">Activity Logs</a>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <?php
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
                $userCount = $stmt->fetch()['count'];
                echo "<p style='font-size: 24px; margin: 10px 0;'>$userCount</p>";
                ?>
            </div>
            <div class="stat-card">
                <h3>Total Admins</h3>
                <?php
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
                $adminCount = $stmt->fetch()['count'];
                echo "<p style='font-size: 24px; margin: 10px 0;'>$adminCount</p>";
                ?>
            </div>
            <div class="stat-card">
                <h3>System Status</h3>
                <p style='font-size: 24px; margin: 10px 0;'>Online</p>
            </div>
        </div>

        <div class="recent-activity">
            <h3>Recent Activity</h3>
            <p>• New user registered: testuser</p>
            <p>• System backup completed</p>
            <p>• Database optimized</p>
        </div>
    </div>
</body>
</html>
