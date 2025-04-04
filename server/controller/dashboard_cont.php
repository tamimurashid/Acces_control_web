<?php 
session_start();
require  "../db.php";

// Total members
$total_query = "SELECT COUNT(*) AS total_members FROM user_deatils";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_members = $total_row['total_members'];

// Count Field Students
$field_query = "SELECT COUNT(*) AS field_students FROM user_deatils WHERE position = 'field'";
$field_result = mysqli_query($conn, $field_query);
$field_row = mysqli_fetch_assoc($field_result);
$field_students = $field_row['field'];

// Count Interns
$intern_query = "SELECT COUNT(*) AS interns FROM user_deatils WHERE position = 'intern'";
$intern_result = mysqli_query($conn, $intern_query);
$intern_row = mysqli_fetch_assoc($intern_result);
$interns = $intern_row['intern'];

// Count Staff
$staff_query = "SELECT COUNT(*) AS staff FROM user_deatils WHERE position = 'staff'";
$staff_result = mysqli_query($conn, $staff_query);
$staff_row = mysqli_fetch_assoc($staff_result);
$staff = $staff_row['staff'];

// Display Results (example output)
echo "👥 Total Members: $total_members<br>";
echo "🎓 Field Students: $field_students<br>";
echo "💼 Interns: $interns<br>";
echo "🧑‍🏫 Staff: $staff<br>";
?>
