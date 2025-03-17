<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Retrieve mode from session or database
$mode = isset($_SESSION['device_mode']) ? $_SESSION['device_mode'] : "auth_mod";

echo json_encode(["status" => $mode]);
?>
