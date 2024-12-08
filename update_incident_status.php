<?php
session_start();
if (!isset($_SESSION['agency_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incident_id = $_POST['incident_id'];
    $status = $_POST['status'];

    $sql = "UPDATE incidents SET status = ? WHERE incident_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $incident_id);

    if ($stmt->execute()) {
        echo "Incident status updated successfully!";
        header("Location: manage_incidents.php"); // Redirect back to the management page
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
