<?php
include('header.php');
session_start();
if (!isset($_SESSION['agency_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Fetch all agencies' information from the database
$sql = "SELECT name,resources,expertise,contact_number, latitude, longitude FROM agencies";
$result = $conn->query($sql);

$agencies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $agencies[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rescue Agencies Map</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 600px;
            width: 100%;
            margin-top: 20px;
        }
        .map-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="map-container">
        <h2>Rescue Agencies Locations</h2>
        <div id="map"></div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize the map and set it to India's coordinates (latitude, longitude) and zoom level
        var map = L.map('map').setView([20.5937, 78.9629], 5); // Coordinates for India

        // Load OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Agencies data from PHP
        var agencies = <?php echo json_encode($agencies); ?>;

        // Add markers for each agency
        // Assuming 'agencies' is an array of agency data
agencies.forEach(function(agency) {
    var marker = L.marker([agency.latitude, agency.longitude]).addTo(map);
    marker.bindPopup(
        "<strong>" + agency.name + "</strong><br>" +
        "Contact: " + agency.contact_number + "<br>" +
        "Expertise: " + agency.expertise + "<br>" +
        "Resources: " + agency.resources
    );
});


        
    </script>
</body>
</html>
