<?php
include('header.php');
include('db_connect.php');

// Incident Resolution Report Query
$query_incidents = "
    SELECT 
        i.incident_type,
        COUNT(i.incident_id) AS total_incidents,
        SUM(CASE WHEN i.status = 'Resolved' THEN 1 ELSE 0 END) AS resolved_incidents,
        AVG(TIMESTAMPDIFF(MINUTE, i.incident_date, NOW())) AS avg_resolution_time
    FROM incidents i
    GROUP BY i.incident_type
";

// Agency Performance Report Query
$query_agencies = "
    SELECT 
        a.name AS agency_name,
        COUNT(DISTINCT i.incident_id) AS incidents_reported,
        COUNT(DISTINCT rr.id) AS requests_made,
        SUM(CASE WHEN rr.status = 'fulfilled' THEN 1 ELSE 0 END) AS requests_fulfilled,
        AVG(TIMESTAMPDIFF(MINUTE, rr.timestamp, ra.timestamp)) AS avg_response_time
    FROM agencies a
    LEFT JOIN incidents i ON a.id = i.agency_id
    LEFT JOIN resource_requests rr ON a.id = rr.requesting_agency_id
    LEFT JOIN resource_allocations ra ON rr.id = ra.resource_id
    GROUP BY a.name
";

// Resource Allocation Report Query
$query_resources = "
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

// Execute Queries
$result_incidents = $conn->query($query_incidents);
$result_agencies = $conn->query($query_agencies);
$result_resources = $conn->query($query_resources);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combined Reports</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e63573;
        }
    </style>
</head>
<body>

<h1>Overall Reports</h1>

<h2>Incident Resolution Report</h2>
<?php
if ($result_incidents->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Incident Type</th>
                <th>Total Incidents</th>
                <th>Resolved Incidents</th>
                <th>Average Resolution Time (minutes)</th>
            </tr>";
    while ($row = $result_incidents->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['incident_type']) . "</td>
                <td>" . intval($row['total_incidents']) . "</td>
                <td>" . intval($row['resolved_incidents']) . "</td>
                <td>" . floatval($row['avg_resolution_time']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No incident resolution data available.";
}
?>

<h2>Agency Performance Report</h2>
<?php
if ($result_agencies->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Agency Name</th>
                <th>Incidents Reported</th>
                <th>Resource Requests Made</th>
                <th>Requests Fulfilled</th>
                <th>Average Response Time (minutes)</th>
            </tr>";
    while ($row = $result_agencies->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['agency_name']) . "</td>
                <td>" . intval($row['incidents_reported']) . "</td>
                <td>" . intval($row['requests_made']) . "</td>
                <td>" . intval($row['requests_fulfilled']) . "</td>
                <td>" . floatval($row['avg_response_time']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No agency performance data available.";
}
?>

<h2>Resource Allocation Report</h2>
<?php
if ($result_resources->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Resource Name</th>
                <th>Total Allocated</th>
                <th>Remaining Quantity</th>
                <th>Agencies Involved</th>
                <th>Requests Fulfilled</th>
            </tr>";
    while ($row = $result_resources->fetch_assoc()) {
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
?>

<?php $conn->close(); ?>

</body>
</html>
