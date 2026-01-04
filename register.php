<?php

require_once 'db.php';

if($_SERVER['REQUEST_METHOD']==="POST"&& isset($_POST['add_student'])){

	$student_id = $_POST['student_id'];
	$name = $_POST['name'];
	$password = $_POST['password'];
	$tableName = "students";
 
	$hassedPassword = password_hash($password, PASSWORD_BCRYPT);

	$sql = "INSERT INTO $tableName (student_id, full_name, password_hash)
			VALUES (?,?,?)";
	try{	
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$student_id, $name, $hassedPassword]);
		echo "Added students succesfully";
		header("Refresh:1, url = login.php");
	}catch(PDOException $e){
		die("Unable to add students: Database error:".$e->getMessage());
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Registration</title>
</head>
<body>
	<form method="POST">
		Student id: <input type="text" name="student_id" required><br>
		Name: <input type="text" name="name" required><br>
		Password: <input type="password" name="password" required><br>

		<button type="submit" name="add_student">Add Student</button>
	</form>
</body>
</html>