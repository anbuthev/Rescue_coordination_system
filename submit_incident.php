<?php
session_start();
if (!isset($_SESSION['agency_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php'; // Ensure this file contains the proper connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agency_id = $_SESSION['agency_id'];
    $incident_title = trim($_POST['incident_title']);
    $incident_description = trim($_POST['incident_description']);
    $incident_type = $_POST['incident_type'];
    $incident_date = $_POST['incident_date'];
    $location_latitude = $_POST['location_latitude'];
    $location_longitude = $_POST['location_longitude'];

    // Check if all required fields are filled out
    if (empty($incident_title) || empty($incident_description) || empty($incident_type) || empty($incident_date) || empty($location_latitude) || empty($location_longitude)) {
        echo "All fields are required!";
        exit();
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO incidents (agency_id, incident_title, incident_description, incident_type, incident_date, location_latitude, location_longitude)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('issssss', $agency_id, $incident_title, $incident_description, $incident_type, $incident_date, $location_latitude, $location_longitude);
        
        if ($stmt->execute()) {
            echo "Incident reported successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
