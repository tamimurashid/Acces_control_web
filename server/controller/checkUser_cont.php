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

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    exit;
}

// Handle request to fetch the scanned card ID
if (isset($data['check']) && $data['check'] === 'scanned_card') {
    $result = $conn->query("SELECT temp_id FROM device_modes LIMIT 1");

    if ($result && $row = $result->fetch_assoc()) {
        $cardID = $row['temp_id'] ?? "";
        echo json_encode(["status" => "success", "cardID" => $cardID]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to fetch scanned card ID"]);
    }
    exit;
}

// Handle authentication and registration mode
if (isset($data['cardID']) && isset($data['mode'])) {
    $cardID = $conn->real_escape_string($data['cardID']);
    $mode = $conn->real_escape_string($data['mode']);

    $_SESSION['scanned_card_id'] = $cardID;

    if ($mode === "auth_mod") {
        // Check if the card ID exists in the database
        $query = "SELECT id FROM user_deatils WHERE card_id = '$cardID' LIMIT 1";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo json_encode(["status" => "success", "code" => "001", "message" => "Card ID exists."]);
        } else {
            echo json_encode(["status" => "error", "code" => "000", "message" => "Card ID not found."]);
        }
    } elseif ($mode === "reg_mod") {
        // Update temp_id in device_modes
        $stmt = $conn->prepare("UPDATE device_modes SET temp_id = ?");
        $stmt->bind_param("s", $cardID);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "temp_id updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database update failed"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "code" => "002", "message" => "Invalid mode. Expected 'auth_mod' or 'reg_mod'."]);
    }
} else {
    echo json_encode(["status" => "error", "code" => "003", "message" => "Missing cardID or mode in the request."]);
}

// Close the database connection
$conn->close();
?>
