<?php
require 'db.php';
if($_SERVER['REQUEST_METHOD']==="POST"&& isset($_POST['login'])){
	$student_id = $_POST['student_id'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM students WHERE student_id = ?";
	try{$stmt = $pdo->prepare($sql);
		$stmt->execute([$student_id]);
		$student = $stmt->fetch();
		if($student){
			$hassedPassword = $student['password_hash'];
			$isPasswordValid = password_verify($password, $hassedPassword);
			if($isPasswordValid){
				session_start();
				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $student['full_name'];
				header("Location: dashboard.php");
			}else{
				echo "Invalid Password";
			}
		}else{
			echo "Invalid Student Id";
		}
	}catch(PDOException $e){
		die("Database Error: ".$e->getMessage());
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Login</title>
</head>
<body>
	<form method="POST">
		Student id: <input type="text" name="student_id" placeholder = "Enter Student id"required><br>
		Password: <input type="password" name="password" required><br>

		<button type = "submit" name = "login">Login</button>
	</form>
</body>
</html>