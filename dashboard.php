<?php

session_start();

require 'db.php';

$user_email = '';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT email FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt-> execute([$user_id ]);
    $user = $stmt->fetch();
    if ($user) {
        $user_email = $user['email'];
    }
}

$logoutMessage = false;

if (isset($_SESSION['just_logged_out'])) {
    $logoutMessage = true;
    unset($_SESSION['just_logged_out']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
<?php if ($logoutMessage): ?>
    <div>You have been logged out successfully. Redirecting to login page...</div>
    <script>
        setTimeout(function(){
            window.location.href = "login.php";
        }, 2000); // 2 seconds
    </script>
<?php endif; ?>

<h1>Welcome to my site</h1>
<?php if ($user_email): ?>
    <p>Logged In User : <?php echo htmlspecialchars($user_email); ?></p>
<?php endif; ?>

<a href="logout.php">
    <button>Logout</button>
    
</a>

</body>
</html>
