<?php
session_start();
require "../db.php";

// Set the headers to allow cross-origin requests and proper JSON response
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

// Get the raw POST data
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);
$_SESSION['scanned_card_id'] = $data;
// Check if cardID and mode are provided in the request

if (isset($data['check']) && $data['check'] === 'scanned_card') {
    // Query the database to get the mode
    $result = $conn->query("SELECT temp_id FROM device_modes LIMIT 1");
    
    if ($result) {
        $row = $result->fetch_assoc();
        // If mode exists in the database, return it; otherwise, return 'auth_mod' as a default
        $temp_id =  $row['temp_id'];
    } else {
        // In case of any database query errors, return 'auth_mod'
        $temp_id  = "";
    }

    // Respond with the mode in a JSON format
    echo json_encode(["status" => $mode]);
} else {
    // In case 'code' is not 'check_mode', return an error response
    echo json_encode(["status" => "error", "message" => "Invalid code"]);
}

if (isset($data['cardID']) && isset($data['mode'])) {
    $cardID = $conn->real_escape_string($data['cardID']);
    $mode  = $conn->real_escape_string($data['mode']);
    // $_SESSION['scanned_card_id'] = $cardID;

    // Check if the mode is "auth_mode"
    if ($mode == "auth_mod") {
        // Query to check if the card ID exists in the database
        $query = "SELECT id FROM cards WHERE card_id = '$cardID' LIMIT 1";
        $result = $conn->query($query);

        // Check if the card ID was found in the database
        if ($result && $result->num_rows > 0) {
            // Card ID exists in the database
            echo json_encode(["status" => "success", "code" => "001", "message" => "Card ID exists."]);
        } else {
            // Card ID does not exist in the database
            echo json_encode(["status" => "error", "code" => "000", "message" => "Card ID not found."]);
        }
        
    } elseif ($mode == "reg_mod"){
        $stmt = $conn->prepare("UPDATE device_modes SET temp_id = ?");
        $stmt->bind_param("s", $cardID);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "temp_id updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database update failed"]);
        }
        $stmt->close();

        }
    else {
        // If the mode is not "auth_mode", return an error message
        echo json_encode(["status" => "error", "code" => "002", "message" => "Invalid mode. Expected 'auth_mod'."]);
    }
} else {
    // If cardID or mode is not provided in the request
    echo json_encode(["status" => "error", "code" => "003", "message" => "Missing cardID or mode in the request."]);
}

// Close the database connection
$conn->close();

