<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'db.php';

$stmt = $conn->prepare("SELECT * FROM students");
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Student List</h2>
<center><a href="add.php">Add Student</a></center>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($students as $student): ?>
    <tr>
        <td><?= $student['id'] ?></td>
        <td><?= $student['name'] ?></td>
        <td><?= $student['email'] ?></td>
        <td><?= $student['course'] ?></td>
        <td>
            <a href="edit.php?id=<?= $student['id'] ?>">Edit</a> |
            <a href="delete.php?id=<?= $student['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>