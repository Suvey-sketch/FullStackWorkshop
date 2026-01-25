<?php

session_start();

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token']= bin2hex(random_bytes(32));
}

require 'db.php';

$error = '';

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $isCSRFvalid = isset($_SESSION['csrf_token'])&& isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
        if(!$isCSRFvalid){
            $error = "Some Error occured. Please try again later.";
        }else{

            $email = $_POST['email'];
            $password = $_POST['password'];

            if(empty($email) || empty($password)){
                $error = "Email and password cannot be empty.";
            }
            else{
                $sql = "SELECT * FROM users WHERE email = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = "Invalid credentials";
                }
            }
        }
    }

} catch (Exception $e) {
    $error = "Something went wrong.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<?php
if (isset($_SESSION['logout_message'])) {
    echo "<p style='color:green;'>" . $_SESSION['logout_message'] . "</p>";
    unset($_SESSION['logout_message']); // remove after showing once
}
?>
<h2>Login</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="text" name="email"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <input type="hidden" name="csrf_token" value ="<?php echo htmlspecialchars($_SESSION['csrf_token'])?>">
    <button type="submit">Login</button>
</form>
<br>
<a href="signup.php">Go to Signup</a>
</body>
</html>