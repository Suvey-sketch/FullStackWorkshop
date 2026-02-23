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

$errors = [];

// Fetch students for dropdown
$sql = $pdo->prepare("SELECT id, full_name, roll_no FROM students ORDER BY full_name");
$sql->execute();
$students = $sql->fetchAll();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $student_id = intval($_POST['student_id']);
    $date = $_POST['date'];
    $status = $_POST['status'];

    // SERVER-SIDE VALIDATION
    if(!$student_id) $errors[] = "Student required";
    if(!$date) $errors[] = "Date required";
    if(!in_array($status, ['Present','Absent'])) $errors[]="Invalid status";

    if(empty($errors)){
        $sql="INSERT INTO attendance (student_id,date,status) VALUES (?,?,?)";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$student_id,$date,$status]);
        echo "<p style='color:green'>Attendance added</p>";
        header('refresh: 2; url=attendance.php');
    }
}
?>

<div class="container">
    <header>
        <h3>Add Daily Attendance</h3>
    </header>

    <div class="form-wrapper">
        <?php foreach($errors as $e) echo "<p style='color:var(--danger); font-weight:bold;'>$e</p>"; ?>

        <form method="POST">
            <div class="form-group">
                <label>Select Student</label>
                <select name="student_id" required>
                    <option value="">-- Choose Student --</option>
                    <?php foreach($students as $s): ?>
                        <option value="<?= $s['id'] ?>">
                            <?= htmlspecialchars($s['full_name']) ?> (<?= htmlspecialchars($s['roll_no']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Attendance Date</label>
                <input type="date" name="date" value="<?= date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="">-- Select Status --</option>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>

            <div class="nav-bar" style="margin-top: 25px;">
                <button type="submit" class="btn-primary">Save Attendance</button>
                <a href="attendance.php" class="btn-secondary">View Records</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
