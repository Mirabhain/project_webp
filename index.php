<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
    header("Location: login.html");
    exit();
}

require 'db.php';
$result = $conn->query("SELECT * FROM restaurant");


?>
<!DOCTYPE html>
<html>
<head>
    <title>Restaurant List</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .restaurant {
            background: #fff;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        a {
            text-decoration: none;
            color: #333;
        }
        .manage-link {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 12px;
            background: #4CAF50;
            color: #fff;
            border-radius: 4px;
        }
    </style>
</head>
<body>
        <h1>Restaurant List</h1>
    <a href="admin/restaurant.php">Manage Restaurants</a>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Location</th><th>Cuisine</th><th>Hours</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['cuisine']) ?></td>
            <td><?= htmlspecialchars($row['hours']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>
