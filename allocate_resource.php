<?php
include('header.php');
session_start();
include('db_connect.php');

// Ensure the agency is logged in
if (!isset($_SESSION['agency_id'])) {
    echo "You must be logged in to allocate resources.";
    exit;
}

$agency_id = $_SESSION['agency_id'];  // The logged-in agency ID

// Fetch resource requests from other agencies
$result = $conn->query("
    SELECT rr.id AS request_id, rr.resource_name, rr.quantity_needed, rr.requesting_agency_id, a.name AS requesting_agency_name
    FROM resource_requests rr
    JOIN agencies a ON rr.requesting_agency_id = a.id
    WHERE rr.status = 'pending' AND rr.requesting_agency_id != $agency_id
");

$requests = [];
while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

// Fetch resources owned by the logged-in agency
$resources_result = $conn->query("SELECT id, resource_name, quantity FROM resources WHERE agency_id = $agency_id");
$resources = [];
while ($row = $resources_result->fetch_assoc()) {
    $resources[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocate Resource</title>
</head>
<body>
<center>
<h2>Resource Requests from Other Agencies</h2>

<?php if (count($requests) > 0): ?>
    <form method="POST" action="submit_allocation.php">
        <table border="1" cellpadding="10">
           <tr>
                <th>Requesting Agency</th>
                <th>Resource Name</th>
                <th>Quantity Needed</th>
                <th>Allocate</th>
            </tr>
            
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['requesting_agency_name']); ?></td>
                    <td><?php echo htmlspecialchars($request['resource_name']); ?></td>
                    <td><?php echo intval($request['quantity_needed']); ?></td>
                    <td>
                        <select name="allocation[<?php echo $request['request_id']; ?>][resource_id]">
                            <option value="">Select Resource</option>
                            <?php foreach ($resources as $resource): ?>
                                <option value="<?php echo $resource['id']; ?>">
                                    <?php echo htmlspecialchars($resource['resource_name']) . " (Available: " . intval($resource['quantity']) . ")"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <label for="quantity">Quantity to Allocate:</label>
                        <input type="number" name="allocation[<?php echo $request['request_id']; ?>][quantity]" min="1" max="<?php echo $resource['quantity']; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <button type="submit">Allocate Resources</button>
    </form>
<?php else: ?>
    <p>No pending resource requests from other agencies.</p>
<?php endif; ?>
</center>
</body>
</html>
