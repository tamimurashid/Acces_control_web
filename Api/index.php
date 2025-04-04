<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

function logEvent($conn, $status, $code, $message){
    $stmt = $conn->prepare("INSERT INTO log (status, code, message) VALUE (?, ?, ?)");
    $stmt->bind_param("sss", $status, $code, $message);
    $stmt->execute();
    $stmt->close();
}

if (!$data) {
    $status = "Error";
    $code = "000";
    $message = "Invalid JSON input";
    logEvent($conn,$status, $code, $message);
    echo json_encode(["status" => "error", "code" => "000", "message" => "Invalid JSON input"]);
    exit;
}

// Mode management
$modeStatus = "auth_mod"; // Default mode

if (isset($data['code'])) {
    if ($data['code'] == "check_mode") {
        echo json_encode([
            "status" => $modeStatus,
            "code" => "009",
            "message" => "Current mode: " . ucfirst(str_replace("_", " ", $modeStatus))
        ]);
        exit;
    } elseif ($data['code'] == "010") {
        $modeStatus = "reg_mod";
    } elseif ($data['code'] == "009") {
        $modeStatus = "auth_mod";
    } else {
        echo json_encode(["status" => "error", "code" => "000", "message" => "Invalid mode request"]);
        exit;
    }

    echo json_encode([
        "status" => $modeStatus,
        "code" => $data['code'],
        "message" => "Scanner switched to " . ucfirst(str_replace("_", " ", $modeStatus)) . " Mode"
    ]);
    exit;
}

// Card Authentication
if (isset($data['cardID'])) {
    $cardID = $data['cardID'];
    $mode = isset($data['mode']) ? $data['mode'] : $modeStatus;

    $url = "http://localhost:8888/Access_control/server/controller/checkUser_cont.php";
    $postData = json_encode(["cardID" => $cardID, "mode" => $mode]);

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        echo json_encode(["status" => "error", "code" => "500", "message" => "Failed to connect to authentication server", "error" => $curlError]);
    } else {
        echo $response;
    }
    exit;
}

// Invalid request
echo json_encode(["status" => "error", "code" => "000", "message" => "Invalid request: cardID or mode code not provided"]);
?>
 