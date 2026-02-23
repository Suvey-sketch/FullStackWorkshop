<?php
require '../config/db.php';
require '../includes/functions.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
requireLogin();

$search = isset($_POST['search']) ? trim($_POST['search']) : '';

if($search === ''){
    exit; // nothing if empty
}

$sql = "SELECT id, roll_no, full_name, department, level
        FROM students
        WHERE full_name LIKE :search
           OR roll_no LIKE :search
           OR department LIKE :search";

$stmt = $pdo->prepare($sql);
$stmt->execute(['search' => "%$search%"]);
$results = $stmt->fetchAll();

if($results){

    echo "<table>";
    echo "<tr>
            <th>Roll</th>
            <th>Name</th>
            <th>Department</th>
            <th>Level</th>
          </tr>";

    foreach($results as $row){
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['roll_no'])."</td>";
        echo "<td>".htmlspecialchars($row['full_name'])."</td>";
        echo "<td>".htmlspecialchars($row['department'])."</td>";
        echo "<td>".htmlspecialchars($row['level'])."</td>";
        echo "</tr>";
    }

    echo "</table>";

}else{
    echo "<p>No results found</p>";
}
?>
