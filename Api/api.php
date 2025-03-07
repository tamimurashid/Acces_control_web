<?php 
include "../server/db.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST, GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

// Get raw JSON input
$rawData = file_get_contents("php://input");

$data = json_decode($rawData, true);

// Retrieve cardID and code (supports both POST JSON and GET requests)
$cardID = $data['cardID'] ?? null;

$code = $_GET['code'] ?? $data['code'] ?? null;

if ($cardID) {
    // If cardID is provided, process registration/authentication
    $res_data = [
        "status" => "success",
        "cardID" => $cardID,
        "message" => "Card scanned successfully"
    ];
} elseif ($code) {
    // If code is provided, handle GET request
    if ($code == '010') {
        $res_data = [
            "status" => 'reg_mod',
            "code" => '010',
            "message" => "Registration in progress"
        ];
    } elseif ($code == '009') {
        $res_data = [
            "status" => 'Auth_mod',
            "code" => '009',
            "message" => "Authentication method on"
        ];
    } else {
        $res_data = [
            "status" => 'error',
            "code" => '000',
            "message" => "Invalid code"
        ];
    }
} else {
    $res_data = [
        "status" => 'error',
        "code" => '000',
        "message" => "Invalid request: cardID or code not provided"
    ];
}

echo json_encode($res_data);
