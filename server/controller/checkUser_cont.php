<?php
session_start();
require "../db.php";

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

// Logging function
function logEvent($conn, $status, $code, $message){
    $stmt = $conn->prepare("INSERT INTO logs (status, code, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $status, $code, $message);
    $stmt->execute();
    $stmt->close();
}

// Get JSON input
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!$data) {
    logEvent($conn, "error", "000", "Invalid JSON input");
    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    exit;
}

// Check scanned card
if (isset($data['check']) && $data['check'] === 'scanned_card') {
    $result = $conn->query("SELECT temp_id FROM device_modes LIMIT 1");

    if ($result && $row = $result->fetch_assoc()) {
        $cardID = $row['temp_id'] ?? "";
        logEvent($conn, "success", "100", "Card ID fetched successfully: $cardID");
        echo json_encode(["status" => "success", "cardID" => $cardID]);
    } else {
        logEvent($conn, "error", "101", "Failed to fetch scanned card ID");
        echo json_encode(["status" => "error", "message" => "Failed to fetch scanned card ID"]);
    }
    exit;
}

// Auth or Reg mode
if (isset($data['cardID']) && isset($data['mode'])) {
    $cardID = $conn->real_escape_string($data['cardID']);
    $mode = $conn->real_escape_string($data['mode']);
    $_SESSION['scanned_card_id'] = $cardID;

    if ($mode === "auth_mod") {
        $query = "SELECT id FROM user_deatils WHERE card_id = '$cardID' LIMIT 1";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            logEvent($conn, "success", "001", "Card ID $cardID authenticated successfully.");
            echo json_encode(["status" => "success", "code" => "001", "message" => "Card ID exists."]);
        } else {
            logEvent($conn, "error", "000", "Card ID $cardID not found.");
            echo json_encode(["status" => "error", "code" => "000", "message" => "Card ID not found."]);
        }

    } elseif ($mode === "reg_mod") {
        $stmt = $conn->prepare("UPDATE device_modes SET temp_id = ?");
        $stmt->bind_param("s", $cardID);
        if ($stmt->execute()) {
            logEvent($conn, "success", "002", "Card ID $cardID registered to temp_id.");
            echo json_encode(["status" => "success", "message" => "temp_id updated successfully"]);
        } else {
            logEvent($conn, "error", "003", "Failed to update temp_id with Card ID $cardID.");
            echo json_encode(["status" => "error", "message" => "Database update failed"]);
        }
        $stmt->close();
    } else {
        logEvent($conn, "error", "004", "Invalid mode: $mode");
        echo json_encode(["status" => "error", "code" => "002", "message" => "Invalid mode. Expected 'auth_mod' or 'reg_mod'."]);
    }
} else {
    logEvent($conn, "error", "005", "Missing cardID or mode in request.");
    echo json_encode(["status" => "error", "code" => "003", "message" => "Missing cardID or mode in the request."]);
}

$conn->close();
?>
