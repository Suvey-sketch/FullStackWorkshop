<?php

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get input values
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    // VALIDATION
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // Show errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        echo "<a href='index.html'>Go Back</a>";
        exit;
    }

    $file = "users.json";

    if (!file_exists($file)) {
        file_put_contents($file, json_encode([]));
    }

    $json = file_get_contents($file);

    if ($json === false) {
        die("Error reading users.json file.");
    }

    $users = json_decode($json, true);

    if (!is_array($users)) {
        $users = [];
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $newUser = [
        "name" => $name,
        "email" => $email,
        "password" => $hashedPassword
    ];

    $users[] = $newUser;

    $saved = file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

    if ($saved === false) {
        die("Error writing to users.json");
    }

    echo "<h3 style='color:green;'>Registration successful!</h3>";
    echo "<a href='index.html'>Register Another User</a>";
}

?>
