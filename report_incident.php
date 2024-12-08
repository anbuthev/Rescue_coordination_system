<?php
include('header.php');
session_start();
if (!isset($_SESSION['agency_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Incident</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <center>
    <h2>Report an Incident</h2>
    <form action="submit_incident.php" method="post">
        <label for="incident_title">Title:</label>
        <input type="text" name="incident_title" id="incident_title" required><br>

        <label for="incident_description">Description:</label>
        <textarea name="incident_description" id="incident_description" required></textarea><br>

        <label for="incident_type">Type of Incident:</label>
        <select name="incident_type" id="incident_type" required>
            <option value="Fire">Fire</option>
            <option value="Flood">Flood</option>
            <option value="Earthquake">Earthquake</option>
            <option value="Accident">Accident</option>
            <option value="Other">Other</option>
        </select><br>

        <label for="incident_date">Date and Time:</label>
        <input type="datetime-local" name="incident_date" id="incident_date" required><br>

        <label for="location_latitude">Latitude:</label>
        <input type="text" name="location_latitude" id="location_latitude" required readonly><br>

        <label for="location_longitude">Longitude:</label>
        <input type="text" name="location_longitude" id="location_longitude" required readonly><br>

        <!-- Leaflet Map -->
        <label for="map">Pin Location on Map:</label>
        <div id="map"></div><br>

        <input type="submit" value="Report Incident">
    </form></center>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize the map and set it to India's coordinates (latitude, longitude) and zoom level
        var map = L.map('map').setView([20.5937, 78.9629], 5); // Coordinates for India

        // Load OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var marker;

        // Function to update the latitude and longitude in the input fields
        function updateLatLng(lat, lng) {
            document.getElementById('location_latitude').value = lat;
            document.getElementById('location_longitude').value = lng;
        }

        // Add a marker on map click and update the lat/long values
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            updateLatLng(e.latlng.lat, e.latlng.lng);
        });
    </script>
</body>
</html>
