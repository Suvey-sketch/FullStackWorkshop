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

$sql = "SELECT g.id, s.full_name, s.roll_no, g.subject, g.marks, g.grade
        FROM grades g
        JOIN students s ON g.student_id = s.id
        ORDER BY g.subject";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();
?>

<div class="container">
    <header>
        <h3>Academic Grade Records</h3>
    </header>

    <div class="nav-bar">
        <div>
            <a href="add_grade.php" class="btn-primary">Add New Grade</a>
            <a href="students.php" class="btn-secondary">Manage Students</a>
        </div>
        
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Roll</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th>Grade</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $s): ?>
                <tr>
                    <td data-label="Roll"><?= htmlspecialchars($s['roll_no']) ?></td>
                    <td data-label="Name"><?= htmlspecialchars($s['full_name']) ?></td>
                    <td data-label="Subject"><?= htmlspecialchars($s['subject']) ?></td>
                    <td data-label="Marks"><?= htmlspecialchars($s['marks']) ?></td>
                    
                    <td style="font-weight:bold; color:var(--primary);"><?= htmlspecialchars($s['grade']) ?></td>
                    <td>
                        <a href="edit_grade.php?id=<?= $s['id'] ?>" class="btn-secondary" style="padding:4px 8px;">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn-danger">Logout</a>
    </div>
</div>


<?php include '../includes/footer.php'; ?>
