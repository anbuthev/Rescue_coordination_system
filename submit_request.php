<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['agency_id'])) {
        $requesting_agency_id = $_SESSION['agency_id'];
        $resource_id = $_POST['resource_id'];
        $quantity_needed = $_POST['quantity_needed'];

        // Get the resource name by ID
        $stmt = $conn->prepare("SELECT resource_name FROM resources WHERE id = ?");
        $stmt->bind_param("i", $resource_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $resource = $result->fetch_assoc();
        $stmt->close();

        if ($resource) {
            $resource_name = $resource['resource_name'];

            // Insert the resource request
            $stmt = $conn->prepare("INSERT INTO resource_requests (requesting_agency_id, resource_name, quantity_needed) VALUES (?, ?, ?)");
            $stmt->bind_param("isi", $requesting_agency_id, $resource_name, $quantity_needed);

            if ($stmt->execute()) {
                echo "Resource request submitted successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Resource not found.";
        }
    } else {
        echo "You must be logged in.";
    }
    $conn->close();
}
?>
