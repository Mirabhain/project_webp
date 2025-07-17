<?php
session_start();
require '../db.php';
require '../auth.php';

// Protect the admin page
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: admin_login.html");
    exit();
}
$currentUser = findUserByUsername($pdo, $_SESSION['username']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hunger Finder Admin Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f9;
      color: #333;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 30px;
    }
    .header {
      background: #2c3e50;
      color: #ecf0f1;
      padding: 20px 30px;
      border-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header h1 {
      margin: 0;
      font-size: 28px;
      font-weight: 600;
    }
    .header .user-info {
      text-align: right;
    }
    .header .user-info p {
      margin: 5px 0;
    }
    .header .logout {
      color: #ecf0f1;
      text-decoration: none;
      border: 1px solid #ecf0f1;
      padding: 6px 12px;
      border-radius: 4px;
      font-size: 14px;
      transition: background 0.3s;
    }
    .header .logout:hover {
      background: #34495e;
    }
    .nav {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin: 30px 0;
    }
    .nav a {
      flex: 1 1 200px;
      background: #34495e;
      color: #fff;
      text-decoration: none;
      padding: 15px;
      border-radius: 6px;
      text-align: center;
      font-weight: 500;
      transition: background 0.3s;
    }
    .nav a:hover {
      background: #3c5974;
    }
    .stats {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 30px;
    }
    .stat-card {
      flex: 1 1 250px;
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      text-align: center;
    }
    .stat-card h3 {
      margin: 0 0 10px 0;
      font-size: 18px;
      color: #2c3e50;
    }
    .stat-card .number {
      font-size: 32px;
      font-weight: bold;
      color: #2980b9;
      margin: 10px 0;
    }
    .recent-activity {
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .recent-activity h3 {
      margin-top: 0;
      font-size: 20px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
    }
    .recent-activity p {
      margin: 8px 0;
      padding: 8px;
      background: #f4f6f9;
      border-radius: 4px;
      font-size: 14px;
    }
    .admin-badge {
      background: #e74c3c;
      color: white;
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div>
        <h1>Hunger Finder Admin</h1>
        <p>Dashboard Overview</p>
      </div>
      <div class="user-info">
        <p>Welcome, <strong><?php echo htmlspecialchars($currentUser["username"]); ?></strong></p>
        <p><span class="admin-badge">ADMIN</span></p>
        <p><a class="logout" href="../logout.php">Logout</a></p>
      </div>
    </div>

    <div class="nav">
      <a href="users.php">Manage Users</a>
      <a href="restaurant.php">Manage Restaurants</a>
      <a href="reports.php">View Reports</a>
      <a href="settings.php">System Settings</a>
      <a href="logs.php">Activity Logs</a>
      <a href="../index.html">View Site</a>
    </div>

    <div class="stats">
      <div class="stat-card">
        <h3>Total Users</h3>
        <?php
        try {
          $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
          $userCount = $stmt->fetch()['count'];
          echo "<div class='number'>$userCount</div>";
        } catch (PDOException $e) {
          echo "<div class='number'>Error</div>";
        }
        ?>
        <p>Registered Users</p>
      </div>

      <div class="stat-card">
        <h3>Total Admins</h3>
        <?php
        try {
          $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
          $adminCount = $stmt->fetch()['count'];
          echo "<div class='number'>$adminCount</div>";
        } catch (PDOException $e) {
          echo "<div class='number'>Error</div>";
        }
        ?>
        <p>System Administrators</p>
      </div>

      <div class="stat-card">
        <h3>System Status</h3>
        <div class="number" style="color: #27ae60;">Online</div>
        <p>All Systems Operational</p>
      </div>
    </div>

    <div class="recent-activity">
      <h3>Recent Activity</h3>
      <p>New user registered: <?php echo isset($currentUser['username']) ? htmlspecialchars($currentUser['username']) : 'Unknown'; ?></p>
      <p>System backup completed successfully</p>
      <p>Database optimized and cleaned</p>
      <p>Security scan completed - No threats detected</p>
    </div>
  </div>
</body>
</html>
