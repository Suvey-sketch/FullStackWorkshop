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

$id = intval($_GET['id']);
$errors = [];

// Fetch record
$stmt = $pdo->prepare("SELECT * FROM attendance WHERE id=?");
$stmt->execute([$id]);
$att = $stmt->fetch();

// Students list
$students = $pdo->query("SELECT id, full_name, roll_no FROM students ORDER BY full_name")->fetchAll();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $student_id = intval($_POST['student_id']);
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Validation
    if(!$student_id) $errors[]="Student required";
    if(!$date) $errors[]="Date required";
    if(!in_array($status,['Present','Absent'])) $errors[]="Invalid status";

    if(empty($errors)){
        $sql="UPDATE attendance SET student_id=?, date=?, status=? WHERE id=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$student_id,$date,$status,$id]);
        echo "<p style='color:green'>Attendance updated successfully</p>";
        header('refresh: 2; url=attendance.php');
    }
}
?>

<div class="container">
    <header>
        <h3>Modify Attendance Record</h3>
    </header>

    <div class="form-wrapper">
        <?php foreach($errors as $e) echo "<p style='color:var(--danger)'>$e</p>"; ?>

        <form method="POST">
            <label>Student</label>
            <select name="student_id" required>
                <?php foreach($students as $s): ?>
                <option value="<?= $s['id'] ?>" <?= ($s['id']==$att['student_id'])?'selected':'' ?>>
                    <?= htmlspecialchars($s['full_name']) ?> (<?= htmlspecialchars($s['roll_no']) ?>)
                </option>
                <?php endforeach; ?>
            </select>

            <label>Date</label>
            <input type="date" name="date" value="<?= htmlspecialchars($att['date']) ?>" required>

            <label>Status</label>
            <select name="status" required>
                <option value="Present" <?= $att['status']=='Present'?'selected':'' ?>>Present</option>
                <option value="Absent" <?= $att['status']=='Absent'?'selected':'' ?>>Absent</option>
            </select>

            <div class="nav-bar" style="margin-top:20px;">
                <button type="submit" class="btn-primary">Update Attendance</button>
                <a href="attendance.php" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
