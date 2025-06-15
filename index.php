<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
    header("Location: login.html");
    exit();
}
?>
<!-- The rest of your index.php here (same as before) -->
