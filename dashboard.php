<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

/* Theme handling using cookie */
$theme = "light"; // default theme

if (isset($_COOKIE['theme'])) {
    $theme = $_COOKIE['theme'];
}

/* Logout handling */
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>

    <style>
        body {
            <?php if ($theme === "dark"): ?>
                background-color: black;
                color: white;
            <?php else: ?>
                background-color: white;
                color: black;
            <?php endif; ?>
        }
    </style>
</head>
<body>

    <h1>Welcome <?= $_SESSION['username'] ?></h1>

    <nav>
        <a href="dashboard.php">Dashboard</a> |
        <a href="preference.php">Change Theme</a>
    </nav>

    <br>

    <form method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>

</body>
</html>