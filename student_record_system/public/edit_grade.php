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

// Fetch grade
$stmt = $pdo->prepare("SELECT * FROM grades WHERE id=?");
$stmt->execute([$id]);
$g = $stmt->fetch();

// Students list
$students = $pdo->query("SELECT id, full_name, roll_no FROM students ORDER BY full_name")->fetchAll();

function calculateGrade($marks){
    if($marks >= 90) return "A+";
    if($marks >= 80) return "A";
    if($marks >= 70) return "B";
    if($marks >= 60) return "C";
    if($marks >= 50) return "D";
    return "F";
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $student_id = intval($_POST['student_id']);
    $subject = clean($_POST['subject']);
    $marks = intval($_POST['marks']);

    // Validation
    if(!$student_id) $errors[]="Student required";
    if(!$subject) $errors[]="Subject required";
    if($marks<0 || $marks>100) $errors[]="Marks must be 0–100";

    if(empty($errors)){
        $grade = calculateGrade($marks);

        $sql="UPDATE grades SET student_id=?, subject=?, marks=?, grade=? WHERE id=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$student_id,$subject,$marks,$grade,$id]);

        echo "<p style='color:green'>Grade updated successfully</p>";
        header('refresh: 2; url=grades.php');
    }
}
?>

<div class="container">
    <header>
        <h3>Edit Grade Record</h3>
    </header>

    <div class="form-wrapper">
        <?php foreach($errors as $e) echo "<p style='color:var(--danger)'>$e</p>"; ?>

        <form method="POST">
            <label>Student</label>
            <select name="student_id" required>
                <?php foreach($students as $s): ?>
                <option value="<?= $s['id'] ?>" <?= ($s['id']==$g['student_id'])?'selected':'' ?>>
                    <?= htmlspecialchars($s['full_name']) ?> (<?= htmlspecialchars($s['roll_no']) ?>)
                </option>
                <?php endforeach; ?>
            </select>

            <label>Subject</label>
            <input name="subject" value="<?= htmlspecialchars($g['subject']) ?>" required>

            <label>Marks</label>
            <input type="number" name="marks" min="0" max="100" value="<?= htmlspecialchars($g['marks']) ?>" required>

            <div class="nav-bar" style="margin-top:20px;">
                <button type="submit" class="btn-primary">Update Grade</button>
                <a href="grades.php" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
