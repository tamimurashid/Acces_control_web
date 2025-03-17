<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "rfid_database";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Set headers for cross-origin and JSON response
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Get the raw data from the POST request (from the firmware)
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Check if 'code' is set to 'check_mode' in the received data
if (isset($data['code']) && $data['code'] === 'check_mode') {
    // Query the database to get the mode
    $result = $conn->query("SELECT mode FROM device_modes LIMIT 1");
    
    if ($result) {
        $row = $result->fetch_assoc();
        // If mode exists in the database, return it; otherwise, return 'auth_mod' as a default
        $mode = $row ? $row['mode'] : "auth_mod";
    } else {
        // In case of any database query errors, return 'auth_mod'
        $mode = "auth_mod";
    }

    // Respond with the mode in a JSON format
    echo json_encode(["status" => $mode]);
} else {
    // In case 'code' is not 'check_mode', return an error response
    echo json_encode(["status" => "error", "message" => "Invalid code"]);
}

?>
