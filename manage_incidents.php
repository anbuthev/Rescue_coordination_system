<?php
session_start();
include('header.php');
if (!isset($_SESSION['agency_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Fetch all incidents with agency name
$sql = "
    SELECT 
        incidents.*, 
        agencies.name AS agency_name
    FROM 
        incidents 
    JOIN 
        agencies 
    ON 
        incidents.agency_id = agencies.id
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Incidents</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h2>Manage Incidents</h2>

    <div id="map"></div>

    <table border="1">
        <tr>
            <th>Agency Name</th>
            <th>Title</th>
            <th>Description</th>
            <th>Type</th>
            <th>Date</th>
            <th>Status</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
        <?php 
        $incidents = []; // Array to store incident data for the map
        while ($row = $result->fetch_assoc()): 
            $incidents[] = $row; // Store each incident in the array
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['agency_name']); ?></td> <!-- Display agency name -->
            <td><?php echo htmlspecialchars($row['incident_title']); ?></td>
            <td><?php echo htmlspecialchars($row['incident_description']); ?></td>
            <td><?php echo htmlspecialchars($row['incident_type']); ?></td>
            <td><?php echo htmlspecialchars($row['incident_date']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['location_latitude']) . ', ' . htmlspecialchars($row['location_longitude']); ?></td>
            <td>
                <form action="update_incident_status.php" method="post">
                    <input type="hidden" name="incident_id" value="<?php echo $row['incident_id']; ?>">
                    <select name="status">
                        <option value="Reported" <?php if ($row['status'] == 'Reported') echo 'selected'; ?>>Reported</option>
                        <option value="In Progress" <?php if ($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                        <option value="Resolved" <?php if ($row['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                    </select>
                    <input type="submit" value="Update Status">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([20.5937, 78.9629], 5);

        // Set up the OSM layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        // Array of incidents from PHP
        var incidents = <?php echo json_encode($incidents); ?>;

        // Add a marker for each incident
        incidents.forEach(function(incident) {
            var latitude = incident.location_latitude;
            var longitude = incident.location_longitude;
            var title = incident.incident_title;
            var description = incident.incident_description;
            var status = incident.status;

            if (latitude && longitude) {
                var marker = L.marker([latitude, longitude]).addTo(map);
                marker.bindPopup("<b>" + title + "</b><br>" + description + "<br>Status: " + status);
            }
        });

        // Fit the map to the markers
        if (incidents.length > 0) {
            var bounds = new L.LatLngBounds(incidents.map(function(incident) {
                return [incident.location_latitude, incident.location_longitude];
            }));
            map.fitBounds(bounds);
        }
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
