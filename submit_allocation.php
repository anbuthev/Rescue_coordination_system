<?php
session_start();
include('db_connect.php');

// Ensure the agency is logged in
if (!isset($_SESSION['agency_id'])) {
    echo "You must be logged in to allocate resources.";
    exit;
}

$agency_id = $_SESSION['agency_id'];  // The logged-in agency ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allocations = $_POST['allocation'];

    foreach ($allocations as $request_id => $allocation) {
        $resource_id = $allocation['resource_id'];
        $quantity = intval($allocation['quantity']);

        if ($resource_id && $quantity > 0) {
            // Fetch the requested resource details
            $resource_result = $conn->query("SELECT quantity FROM resources WHERE id = $resource_id AND agency_id = $agency_id");
            $resource = $resource_result->fetch_assoc();

            // Check if enough quantity is available
            if ($resource && $resource['quantity'] >= $quantity) {
                // Update the resource quantity
                $new_quantity = $resource['quantity'] - $quantity;
                $conn->query("UPDATE resources SET quantity = $new_quantity WHERE id = $resource_id AND agency_id = $agency_id");

                // Insert into resource_allocations table
                $stmt = $conn->prepare("INSERT INTO resource_allocations (resource_id, allocating_agency_id, receiving_agency_id, quantity) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiii", $resource_id, $agency_id, $requesting_agency_id, $quantity);

                // Get the requesting agency ID from the request
                $request_result = $conn->query("SELECT requesting_agency_id FROM resource_requests WHERE id = $request_id");
                $request = $request_result->fetch_assoc();
                $requesting_agency_id = $request['requesting_agency_id'];

                if ($stmt->execute()) {
                    // Update the resource request to mark it as fulfilled
                    $conn->query("UPDATE resource_requests SET status = 'fulfilled' WHERE id = $request_id");
                    echo "Resource allocated successfully!";
                } else {
                    echo "Error allocating resource: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error: Not enough quantity available.";
            }
        }
    }

    $conn->close();
}
?>