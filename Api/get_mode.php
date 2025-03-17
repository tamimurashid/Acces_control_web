<?php
session_start();
require "../db.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$result = $conn->query("SELECT mode FROM device_modes LIMIT 1");
$row = $result->fetch_assoc();

echo json_encode(["status" => $row ? $row['mode'] : "auth_mod"]);
?>
