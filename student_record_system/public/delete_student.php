<?php
require '../config/db.php';

$id = intval($_GET['id']);

$stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
$stmt->execute([$id]);

header("Location: students.php");
exit;
?>
