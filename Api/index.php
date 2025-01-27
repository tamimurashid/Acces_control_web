<?php

include"../server/db.php";
// Get the raw POST data
$rawData = file_get_contents("php://input");

// Decode JSON data
$data = json_decode($rawData, true);

if (isset($data['cardID'])) {
    $cardID = $conn->real_escape_string($data['cardID']);

    // Query to check if the card ID exists in the database
    $query = "SELECT id FROM cards WHERE card_id = '$cardID' LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Card ID exists in the database
        echo json_encode(["status" => "success", "code" => "001", "message" => "Card ID exists."]);
    } else {
        // Card ID does not exist in the database
        echo json_encode(["status" => "success", "code" => "000", "message" => "Card ID not found."]);
    }
} else {
    // Invalid request
    echo json_encode(["status" => "error", "message" => "Invalid request: cardID not provided"]);
}

// Close connection
$conn->close();
?>
