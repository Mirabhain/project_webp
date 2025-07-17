<?php
require '../db.php';

// CREATE
if (isset($_POST['create'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $location = $conn->real_escape_string($_POST['location']);
    $cuisine = $conn->real_escape_string($_POST['cuisine']);
    $hours = $conn->real_escape_string($_POST['hours']);
    $conn->query("INSERT INTO restaurant (name, location, cuisine, hours) VALUES ('$name', '$location', '$cuisine', '$hours')");
    header("Location: restaurant.php");
    exit;
}

// UPDATE
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $location = $conn->real_escape_string($_POST['location']);
    $cuisine = $conn->real_escape_string($_POST['cuisine']);
    $hours = $conn->real_escape_string($_POST['hours']);
    $conn->query("UPDATE restaurant SET name='$name', location='$location', cuisine='$cuisine', hours='$hours' WHERE id=$id");
    header("Location: restaurant.php");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM restaurant WHERE id=$id");
    header("Location: restaurant.php");
    exit;
}

// READ
$restaurants = $conn->query("SELECT * FROM restaurant");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Restaurant</title>
</head>
<body>
    <h1>Manage Restaurants</h1>
    <a href="../index.html">View Main Page</a>

    <h2>Add New Restaurant</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="location" placeholder="Location" required>
        <input type="text" name="cuisine" placeholder="Cuisine" required>
        <input type="text" name="hours" placeholder="Hours" required>
        <button type="submit" name="create">Add</button>
    </form>

    <h2>Restaurant List</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th><th>Name</th><th>Location</th><th>Cuisine</th><th>Hours</th><th>Actions</th>
        </tr>
        <?php while ($row = $restaurants->fetch_assoc()): ?>
            <?php if (isset($_GET['edit']) && $_GET['edit'] == $row['id']): ?>
                <tr>
                    <form method="post">
                        <td><?= $row['id'] ?><input type="hidden" name="id" value="<?= $row['id'] ?>"></td>
                        <td><input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>"></td>
                        <td><input type="text" name="location" value="<?= htmlspecialchars($row['location']) ?>"></td>
                        <td><input type="text" name="cuisine" value="<?= htmlspecialchars($row['cuisine']) ?>"></td>
                        <td><input type="text" name="hours" value="<?= htmlspecialchars($row['hours']) ?>"></td>
                        <td>
                            <button type="submit" name="update">Save</button>
                            <a href="restaurant.php">Cancel</a>
                        </td>
                    </form>
                </tr>
            <?php else: ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= htmlspecialchars($row['cuisine']) ?></td>
                    <td><?= htmlspecialchars($row['hours']) ?></td>
                    <td>
                        <a href="restaurant.php?edit=<?= $row['id'] ?>">Edit</a> | 
                        <a href="restaurant.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this restaurant?')">Delete</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endwhile; ?>
    </table>
</body>
</html>

