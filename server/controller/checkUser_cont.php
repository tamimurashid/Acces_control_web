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

// Check if cardID and mode are provided in the request
if (isset($data['cardID']) && isset($data['mode'])) {
    $cardID = $conn->real_escape_string($data['cardID']);
    $mode  = $conn->real_escape_string($data['mode']);
    $_SESSION['scanned_card_id'] = $cardID;

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
    } else {
        // If the mode is not "auth_mode", return an error message
        echo json_encode(["status" => "error", "code" => "002", "message" => "Invalid mode. Expected 'auth_mod'."]);
    }
} else {
    // If cardID or mode is not provided in the request
    echo json_encode(["status" => "error", "code" => "003", "message" => "Missing cardID or mode in the request."]);
}

// Close the database connection
$conn->close();

