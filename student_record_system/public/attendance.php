<?php
require '../config/db.php';
require '../includes/functions.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
requireLogin();

include '../includes/header.php';

$sql = "SELECT a.id, s.full_name, s.roll_no, a.date, a.status
        FROM attendance a
        JOIN students s ON a.student_id = s.id
        ORDER BY a.date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();
?>

<div class="container">
    <header><h3>Attendance Records</h3></header>
    
    <div class="nav-bar">
        <div>
            <a href="add_attendance.php" class="btn-primary">Add Attendance</a>
            <a href="students.php" class="btn-secondary">Students</a>
        </div>
        
    </div>

    <div class="table-container">
        <table>
            <tr><th>Roll</th><th>Name</th><th>Date</th><th>Status</th><th>Action</th></tr>
            <?php foreach($data as $s): ?>
            <tr>
                <td data-label="Roll"><?= htmlspecialchars($s['roll_no']) ?></td>
                <td data-label="Name"><?= htmlspecialchars($s['full_name']) ?></td>
                <td data-label="Date"><?= htmlspecialchars($s['date']) ?></td>
                <td data-label="Status"><?= htmlspecialchars($s['status']) ?></td>
                
                <td><a href="edit_attendance.php?id=<?= $s['id'] ?>" class="btn-secondary">Edit</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="logout.php" class="btn-danger">Logout</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
