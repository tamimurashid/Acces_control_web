<?php 

// Database connection settings
$servername = "localhost";
$username = "root";       // Replace with your database username
$password = "root";           // Replace with your database password
$dbname = "rfid_database"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}