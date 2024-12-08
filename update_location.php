<?php
session_start();
if (!isset($_SESSION['agency_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

require 'db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validate input data
if (!isset($data['latitude']) || !isset($data['longitude'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit();
}

$latitude = $data['latitude'];
$longitude = $data['longitude'];
$agency_id = $_SESSION['agency_id'];

// Update agency location in the database
$stmt = $conn->prepare("UPDATE agencies SET latitude = ?, longitude = ? WHERE agency_id = ?");
$stmt->bind_param("ddi", $latitude, $longitude, $agency_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Location updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update location"]);
}

$stmt->close();
$conn->close();
?>
