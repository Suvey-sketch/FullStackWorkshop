<?php
require '../includes/functions.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
requireLogin();
?>
<?php include '../includes/header.php'; ?>

<div class="container">
    <header>
        <h3>Dashboard</h3>
    </header>

    <div class="nav-bar" style="display: flex; gap: 15px; margin-bottom: 50px;">
        <a href="students.php" class="btn-primary" style="flex: 1; text-align: center;">Manage Students</a>
        <a href="add_student.php" class="btn-secondary" style="flex: 1; text-align: center;">Add Student</a>
    </div>

    <footer style="display: flex; justify-content: flex-end; margin-top: 40px;">
        <a href="logout.php" class="btn-danger">Logout</a>
    </footer>
</div>

<?php include '../includes/footer.php'; ?>