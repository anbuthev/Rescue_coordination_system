<?php
include('header.php');
session_start();
include('db_connect.php');

if (!isset($_SESSION['agency_id'])) {
    echo "You must be logged in to request resources.";
    exit;
}

$agency_id = $_SESSION['agency_id'];

// Fetch resources available for request (not owned by the requesting agency)
$result = $conn->query("SELECT id, resource_name, quantity FROM resources WHERE agency_id != $agency_id");

$available_resources = [];
while ($row = $result->fetch_assoc()) {
    $available_resources[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Resource</title>
</head>
<body>
    <center><h2>Request a Resource</h2>
    <form method="POST" action="submit_request.php">
        <label for="resource">Select Resource:</label>
        <select name="resource_id" id="resource" required>
            <option value="">Select a resource</option>
            <?php foreach ($available_resources as $resource): ?>
                <option value="<?php echo $resource['id']; ?>">
                    <?php echo htmlspecialchars($resource['resource_name']) . " (Available: " . intval($resource['quantity']) . ")"; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="quantity_needed">Quantity Needed:</label>
        <input type="number" name="quantity_needed" id="quantity_needed" required min="1"><br><br>

        <button type="submit">Request Resource</button>
    </form></center>
</body>
</html>
