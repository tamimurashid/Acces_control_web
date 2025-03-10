<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST, GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Check if the request contains a cardID
if (isset($data['cardID'])) {
    $cardID = $data['cardID'];

    // Forward cardID to checkUser-cont.php
    $url = "http://localhost:8888/Access_control/server/controller/checkUser_cont.php";
    
    $postData = json_encode(["cardID" => $cardID]);

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
    // Execute request and get response
    $response = curl_exec($ch);
    curl_close($ch);

    // Send the response back to the scanner
    echo $response;

} elseif (isset($data['code'])) {
    // Handle mode switching for the scanner
    $code = $data['code'];

    if ($code == "010") {
        // Registration mode
        echo json_encode([
            "status" => "reg_mod",
            "code" => "010",
            "message" => "Scanner switched to Registration Mode."
        ]);
    } elseif ($code == "009") {
        // Authentication mode
        echo json_encode([
            "status" => "auth_mod",
            "code" => "009",
            "message" => "Scanner switched to Authentication Mode."
        ]);
    }else {
        // Invalid mode code
        echo json_encode([
            "status" => "error",
            "code" => "000",
            "message" => "Invalid mode request."
        ]);
    }
}elseif (isset($data['code']) && $data['code'] == "check_mode") {
        echo json_encode([
            "status" => "auth_mod",  // Change this dynamically as needed
            "code" => "009",
            "message" => "Current mode: Authentication"
        ]);
 }else {
    echo json_encode([
        "status" => "error",
        "code" => "000",
        "message" => "Invalid request: cardID or mode code not provided"
    ]);
}
?>
