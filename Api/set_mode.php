<?php
session_start();
require "../db.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (isset($data['mode'])) {
    $mode = $conn->real_escape_string($data['mode']);

    // Store the mode in session or database
    $_SESSION['device_mode'] = $mode;

    echo json_encode(["status" => "success", "message" => "Mode updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Mode not provided"]);
}
?>
