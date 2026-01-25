<?php
session_start();

// Mark logout action
$_SESSION['just_logged_out'] = true;

// Remove login session
unset($_SESSION['user_id']);

// Redirect back to dashboard
header("Location: dashboard.php");
exit;
?>
