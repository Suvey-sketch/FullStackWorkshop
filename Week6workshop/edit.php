<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update = $conn->prepare(
        "UPDATE students SET name=?, email=?, course=? WHERE id=?"
    );
    $update->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['course'],
        $id
    ]);
    header("Location: index.php");
}
?>

<h2>Edit Student</h2>

<form method="POST">
    Name:<br>
    <input type="text" name="name" value="<?= $student['name'] ?>"><br><br>

    Email:<br>
    <input type="email" name="email" value="<?= $student['email'] ?>"><br><br>

    Course:<br>
    <input type="text" name="course" value="<?= $student['course'] ?>"><br><br>

    <button type="submit">Update</button>
</form>

</body>
</html>