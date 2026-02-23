<?php
session_start();

$_SESSION = [];
session_destroy();

header("Location: login.php");
exit;

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="2;url=login.php">
</head>
<body>
<p style="text-align:center;">Logged out successfully. Redirecting to login...</p>
</body>
</html>

