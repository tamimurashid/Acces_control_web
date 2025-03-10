<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Handle checking the current mode
if (isset($data['code']) && $data['code'] == "check_mode") {
    echo json_encode([
        "status" => "auth_mod",  // Change dynamically if needed
        "code" => "009",
        "message" => "Current mode: Authentication"
    ]);
    exit;
}

// Handle card authentication
if (isset($data['cardID'])) {
    $cardID = $data['cardID'];
    $mode = isset($data['mode']) ? $data['mode'] : "auth_mod"; // Default mode

    $url = "http://localhost:8888/Access_control/server/controller/checkUser_cont.php";
    $postData = json_encode(["cardID" => $cardID, "mode" => $mode]);

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;
    exit;
}

// Handle mode switching
if (isset($data['code'])) {
    if ($data['code'] == "010") {
        echo json_encode(["status" => "reg_mod", "code" => "010", "message" => "Scanner switched to Registration Mode."]);
    } elseif ($data['code'] == "009") {
        echo json_encode(["status" => "auth_mod", "code" => "009", "message" => "Scanner switched to Authentication Mode."]);
    } else {
        echo json_encode(["status" => "error", "code" => "000", "message" => "Invalid mode request."]);
    }
    exit;
}

// Invalid request
echo json_encode(["status" => "error", "code" => "000", "message" => "Invalid request: cardID or mode code not provided"]);
?>
