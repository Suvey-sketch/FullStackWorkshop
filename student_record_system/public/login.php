<?php
session_start();
require '../config/db.php';
require '../includes/functions.php';

/* Generate CSRF token */
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* CSRF check */
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        $error = "Invalid request.";
    } else {

        $email = clean($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $error = "Email and password are required.";
        } else {

            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {

                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_email'] = $admin['email'];

                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid login credentials.";
            }

        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/css/ui.css">
</head>
<body>

<?php if ($error): ?>
<p style="color:red; text-align:center"><?= $error ?></p>
<?php endif; ?>

<div class="login-wrapper">
    <div class="login-card">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <p style="color:#c40c0c; text-align:center"><?= $error ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-blue" style="width: 100%;">LOGIN</button>
        </form>
    </div>
</div>
</body>
</html>
