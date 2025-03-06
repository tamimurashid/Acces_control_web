<?php
$servername = "localhost";
$username = "root";       
$password = "root";           
$dbname = "rfid_database"; 

// Cre
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
echo "Connected successfully!<br>"; // TEMPORARY debug message
