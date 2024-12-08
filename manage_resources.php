<?php
include('header.php');
session_start();
include('db_connect.php');

// Ensure the agency is logged in
if (!isset($_SESSION['agency_id'])) {
    echo "You must be logged in to manage resources.";
    exit;
}

$agency_id = $_SESSION['agency_id'];

// Fetch the resources of the logged-in agency
$result = $conn->query("SELECT id, resource_name, quantity, unit FROM resources WHERE agency_id = $agency_id");
$resources = [];

while ($row = $result->fetch_assoc()) {
    $resources[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resources</title>
</head>
<body>
<center>
<h2>Manage Resources</h2>

<a href="add_resource.php" style="color:fuchsia; font-weight: bold;">Add New Resource</a><br><br>


<table border="1" cellpadding="10">
    <tr>
        <th>Resource Name</th>
        <th>Quantity</th>
        <th>Unit</th>
     
    </tr>
    <?php foreach ($resources as $resource): ?>
        <tr>
            <td><?php echo htmlspecialchars($resource['resource_name']); ?></td>
            <td><?php echo intval($resource['quantity']); ?></td>
            <td><?php echo htmlspecialchars($resource['unit']); ?></td>
            
        </tr>
    <?php endforeach; ?>
</table>
</center>
</body>
</html>
