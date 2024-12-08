<?php
include('db_connect.php'); // Assuming this file connects to your database

// Query to generate the Resource Allocation Report
$query = "
    SELECT 
        r.resource_name,
        SUM(ra.quantity) AS total_allocated,
        (r.quantity - SUM(ra.quantity)) AS remaining_quantity,
        COUNT(DISTINCT ra.receiving_agency_id) AS agencies_involved,
        COUNT(DISTINCT ra.id) AS requests_fulfilled
    FROM resources r
    JOIN resource_allocations ra ON r.id = ra.resource_id
    GROUP BY r.resource_name
";

$result = $conn->query($query);

// Display the report
if ($result->num_rows > 0) {
    echo "<h2>Resource Allocation Report</h2>";
    echo "<table border='1'>
            <tr>
                <th>Resource Name</th>
                <th>Total Allocated</th>
                <th>Remaining Quantity</th>
                <th>Agencies Involved</th>
                <th>Requests Fulfilled</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['resource_name']) . "</td>
                <td>" . intval($row['total_allocated']) . "</td>
                <td>" . intval($row['remaining_quantity']) . "</td>
                <td>" . intval($row['agencies_involved']) . "</td>
                <td>" . intval($row['requests_fulfilled']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No resource allocation data available.";
}

$conn->close();
?>
