<?php
session_start();
require  "../db.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);


// Check if cardID is provided
if (isset($data['cardID'])) {
    $cardID = $conn->real_escape_string($data['cardID']);
    $_SESSION['scanned_card_id'] =  $cardID;

    // Query to check if the card ID exists in the database
    $query = "SELECT id FROM cards WHERE card_id = '$cardID' LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Card ID exists in the database
        echo json_encode(["status" => "success", "code" => "001", "message" => "Card ID exists."]);
    } else {
        // Card ID does not exist in the database
        echo json_encode(["status" => "error", "code" => "000", "message" => "Card ID not found."]);
    }
} else {
    echo json_encode(["status" => "error", "code" => "000", "message" => "Invalid request: cardID not provided"]);
}

// Close connection
$conn->close();
?>
