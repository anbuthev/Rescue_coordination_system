<?php
session_start();
include('db_connect.php');

// Ensure the agency is logged in
if (!isset($_SESSION['agency_id'])) {
    echo "You must be logged in to add a resource.";
    exit;
}

$agency_id = $_SESSION['agency_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the resource details from the form
    $resource_name = $_POST['resource_name'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];

    // Prepare the SQL statement to insert the new resource
    $stmt = $conn->prepare("INSERT INTO resources (agency_id, resource_name, quantity, unit) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $agency_id, $resource_name, $quantity, $unit);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Resource added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
