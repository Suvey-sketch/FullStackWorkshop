<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require '../config/db.php';
require '../includes/functions.php';

requireLogin();

include '../includes/header.php';
$sql = "SELECT id, roll_no, full_name, department, level FROM students ORDER BY CAST(roll_no AS UNSIGNED) ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="container">
    <section class="header-area">
        <h3>Manage Students</h3>
        <div class="nav-actions">
            <a href="index.php" class="btn-secondary">Dashboard</a>
            <a href="add_student.php" class="btn-primary">Add New Student</a>
            <a href="attendance.php" class="btn-primary">Check Attendance</a>
            <a href="grades.php"class="btn-primary">Check Grades</a>
            <a href="logout.php" class="btn-danger">Logout</a>
        </div>
    </section>

    <section class="search-section">
        <input type="text" id="search" placeholder="Search by name or roll no..." class="form-control">
        <div id="results"></div>
    </section>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Roll</th>
                    <th>Name</th>
                    <th>Dept</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($students as $s): ?>
                <tr>
                    <td data-label="Roll"><?= htmlspecialchars($s['roll_no']) ?></td>
                    <td data-label="Name"><?= htmlspecialchars($s['full_name']) ?></td>
                    <td data-label="Dept"><?= htmlspecialchars($s['department']) ?></td>
                    <td data-label="Level"><?= htmlspecialchars($s['level']) ?></td>
                    <td>
                        <a href="edit_student.php?id=<?= $s['id'] ?>" class="btn-secondary" style="padding: 5px 10px;">Edit</a>
                        <a href="delete_student.php?id=<?= $s['id'] ?>" class="btn-danger" style="padding: 5px 10px;" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>



<script>
const searchInput = document.getElementById('search');
const resultDiv = document.getElementById('results');

searchInput.addEventListener('input', function(){

    const query = this.value.trim();

    if(query === ''){
        resultDiv.innerHTML = '';
        return;
    }

    const formData = new FormData();
    formData.append('search', query);

    fetch('search.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(html => {
        resultDiv.innerHTML = html;
    })
    .catch(err => console.error('JS ERROR:', err));
});
</script>

<?php include '../includes/footer.php'; ?>
