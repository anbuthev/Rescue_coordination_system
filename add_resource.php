<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['agency_id'])) {
        $agency_id = $_SESSION['agency_id'];
        $resource_name = $_POST['resource_name'];
        $quantity = $_POST['quantity'];
        $unit = $_POST['unit'];

        // Insert resource
        $stmt = $conn->prepare("INSERT INTO resources (agency_id, resource_name, quantity, unit) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $agency_id, $resource_name, $quantity, $unit);

        if ($stmt->execute()) {
            echo "Resource added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "You must be logged in.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Resource</title>
</head>
<body>

<h2>Add a New Resource</h2>

<form method="POST" action="submit_resource.php">
    <label for="resource_name">Resource Name:</label>
    <input type="text" name="resource_name" id="resource_name" required><br><br>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" required><br><br>

    <label for="unit">Unit (e.g., liters, units):</label>
    <input type="text" name="unit" id="unit" required><br><br>

    <button type="submit">Add Resource</button>
</form>

</body>
</html>