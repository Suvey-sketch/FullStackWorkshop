<?php
$host = "localhost";
// $database   = "NP03CS4A240081";
// $username = "NP03CS4A240081";
// $password = "oJW3dJvqCl";

$database   = "student_system";
$username = "root";
$password = "";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("DB Connection Failed");
}
?>
