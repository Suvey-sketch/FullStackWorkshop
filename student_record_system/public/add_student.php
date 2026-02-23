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

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $roll = clean($_POST['roll']);
    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $phone = clean($_POST['phone']);
    $dept = clean($_POST['dept']);
    $level = clean($_POST['level']);
    $sem = clean($_POST['sem']);
    $dob = $_POST['dob'];

    // SERVER-SIDE VALIDATION
    if(!$roll) $errors[]="Roll number required";
    if(!$name) $errors[]="Name required";
    if(!isEmail($email)) $errors[]="Invalid email";
    if(!isPhone($phone)) $errors[]="Invalid phone number";
    if(!$dept || !$level || !$sem || !$dob) $errors[]="All fields required";

    if(empty($errors)){
        $sql = "INSERT INTO students 
        (roll_no, full_name, email, phone, department, level, semester, date_of_birth)
        VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$roll,$name,$email,$phone,$dept,$level,$sem,$dob]);

        if($result){
            echo "<p style='color:green'>Student added successfully</p>";
            header('Location: students.php');
        }

    }
}
?>

<div class="container">
    <header>
        <h3>Add New Student</h3>
    </header>

    <div class="form-wrapper">
        <?php foreach($errors as $e) echo "<p style='color:var(--danger)'>$e</p>"; ?>
        
        <form method="POST">
            <label>Roll Number</label>
            <input name="roll" required>
            
            <label>Full Name</label>
            <input name="name" required>
            
            <label>Email</label>
            <input name="email" type="email" required>
            
            <label>Phone</label>
            <input name="phone" pattern="(97|98)[0-9]{8}" required>
            
            <label>Department: </label>
            <input name="dept" required><br>

            <label>Level: </label>
            <input name="level" required><br>

            <label>Semester: </label>
            <input name="sem" required><br>

            <label>Date of Birth: </label>
            <input type="date" name="dob" required><br>

            <div class="nav-bar" style="margin-top:20px;">
                <button class="btn-primary">Save Student</button>
                <a href="students.php" class="btn-secondary">Cancel</a> 
            </div>
        </form>
    </div>
</div>

<script>
function validateForm(){
    return true; // HTML5 validation already active
}
</script>

<?php include '../includes/footer.php'; ?>
