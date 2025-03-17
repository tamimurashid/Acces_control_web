<?php
session_start();
// Database credentials
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "rfid_database";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (isset($data['mode'])) {
    $mode = $conn->real_escape_string($data['mode']);

    // Update mode in database
    $stmt = $conn->prepare("UPDATE device_modes SET mode = ?");
    $stmt->bind_param("s", $mode);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Mode updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed"]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Mode not provided"]);
}

