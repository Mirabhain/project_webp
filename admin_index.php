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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hunger Finder</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 25px; 
            border-radius: 10px; 
            margin-bottom: 30px; 
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
        }
        .header .user-info {
            text-align: right;
        }
        .header .user-info p {
            margin: 5px 0;
        }
        .header a { 
            color: #fff; 
            text-decoration: none; 
            background: rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 20px;
            transition: background 0.3s;
        }
        .header a:hover {
            background: rgba(255,255,255,0.3);
        }
        .nav { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-bottom: 30px; 
        }
        .nav a { 
            padding: 15px 20px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            text-decoration: none; 
            border-radius: 10px; 
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            font-weight: 600;
        }
        .nav a:hover { 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px; 
        }
        .stat-card { 
            padding: 25px; 
            border-radius: 15px; 
            text-align: center; 
            color: white;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card.users { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .stat-card.admins { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .stat-card.status { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; }
        .stat-card h3 {
            margin: 0 0 15px 0;
            font-size: 18px;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }
        .recent-activity { 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 25px; 
            border-radius: 15px; 
        }
        .recent-activity h3 {
            margin-top: 0;
            font-size: 24px;
        }
        .recent-activity p {
            margin: 10px 0;
            padding: 10px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
        }
        .admin-badge {
            background: #dc3545;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>🍽️ Hunger Finder Admin</h1>
                <p>System Management Dashboard</p>
            </div>
            <div class="user-info">
               <p>Welcome back, <strong><?php echo htmlspecialchars($currentUser["username"]); ?></strong></p>
                <p><span class="admin-badge">ADMIN</span></p>
                <p><a href="../logout.php">🚪 Logout</a></p>
            </div>
        </div>

        <div class="nav">
            <a href="users.php">👥 Manage Users</a>
            <a href="restaurants.php">🏪 Manage Restaurants</a>
            <a href="reports.php">📊 View Reports</a>
            <a href="settings.php">⚙️ System Settings</a>
            <a href="logs.php">📋 Activity Logs</a>
            <a href="../index.html">🏠 View Site</a>
        </div>

        <div class="stats">
            <div class="stat-card users">
                <h3>👤 Total Users</h3>
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
            
            <div class="stat-card admins">
                <h3>👑 Total Admins</h3>
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
            
            <div class="stat-card status">
                <h3>🟢 System Status</h3>
                <div class='number'>Online</div>
                <p>All Systems Operational</p>
            </div>
        </div>

        <div class="recent-activity">
            <h3>📈 Recent Activity</h3>
            <p>🆕 New user registered: <?php echo isset($currentUser['username']) ? htmlspecialchars($currentUser['username']) : 'Unknown'; ?></p>
            <p>💾 System backup completed successfully</p>
            <p>🔧 Database optimized and cleaned</p>
            <p>🔒 Security scan completed - No threats detected</p>
        </div>
    </div>
</body>
</html>
