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

$stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
$stmt->execute([$id]);
$s = $stmt->fetch();

$errors=[];

if($_POST){
    $roll = clean($_POST['roll']);
    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $phone = clean($_POST['phone']);
    $dept = clean($_POST['dept']);
    $level = clean($_POST['level']);
    $sem = clean($_POST['sem']);
    $dob = $_POST['dob'];

    if(!$roll||!$name||!$email||!$phone||!$dept||!$level||!$sem||!$dob) $errors[]="All fields required";

        if(empty($errors)){

    // Check if roll_no, email, or phone already exists for a different student
    $check = $pdo->prepare("
        SELECT * FROM students 
        WHERE (roll_no = ? OR email = ? OR phone = ?) AND id != ?
    ");
    $check->execute([$roll, $email, $phone, $id]);

    $conflicts = $check->fetchAll(PDO::FETCH_ASSOC);

    if(count($conflicts) > 0){
        foreach($conflicts as $existingStudent){
            if($existingStudent['roll_no'] == $roll){
                $errors[] = "Roll number '$roll' is already taken by another student.";
            }
            if($existingStudent['email'] == $email){
                $errors[] = "Email '$email' is already taken by another student.";
            }
            if($existingStudent['phone'] == $phone){
                $errors[] = "Phone number '$phone' is already taken by another student.";
            }
        }
    } else {
        // No conflicts, safe to update
        $sql = "UPDATE students SET
            roll_no=?, full_name=?, email=?, phone=?, department=?, level=?, semester=?, date_of_birth=? 
            WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$roll,$name,$email,$phone,$dept,$level,$sem,$dob,$id]);
        echo "<p style='color:green'>Updated successfully</p>";
        header('refresh: 2; url=students.php');
        exit;
    

    }
}

}
?>


<div class="container">
    <header>
        <h3>Update Student</h3>
    </header>

    <div class="form-wrapper">
        <?php foreach($errors as $e) echo "<p style='color:var(--danger)'>$e</p>"; ?>
        
        <form method="POST">
            <label>Roll Number</label>
            <input name="roll" value="<?= htmlspecialchars($s['roll_no']) ?>" required>
            
            <label>Full Name</label>
            <input name="name" value="<?= htmlspecialchars($s['full_name']) ?>"required>
            
            <label>Email</label>
            <input name="email" type="email" value="<?= htmlspecialchars($s['email']) ?>"required>
            
            <label>Phone</label>
            <input name="phone" pattern="(97|98)[0-9]{8}" value ="<?= htmlspecialchars($s['phone']) ?>" required>
            
            <label>Department: </label>
            <input name="dept" value="<?= htmlspecialchars($s['department']) ?>"required><br>

            <label>Level: </label>
            <input name="level" value="<?= htmlspecialchars($s['level']) ?>"required><br>

            <label>Semester: </label>
            <input name="sem" value="<?= htmlspecialchars($s['semester']) ?>"required><br>

            <label>Date of Birth: </label>
            <input type="date" name="dob" value="<?= htmlspecialchars($s['date_of_birth'])?>" required><br>

            <div class="nav-bar" style="margin-top:20px;">
                <button class="btn-primary">Update Student</button>
                <a href="students.php" class="btn-secondary">Cancel</a>   
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
