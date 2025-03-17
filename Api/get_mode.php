<?php
session_start();
require "../server/db.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$result = $conn->query("SELECT mode FROM device_modes LIMIT 1");
$row = $result->fetch_assoc();

echo json_encode(["status" => $row ? $row['mode'] : "auth_mod"]);

