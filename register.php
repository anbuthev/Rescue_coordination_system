<?php
require 'db_connect.php'; // Include database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Registration</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        /* Full-screen background animation */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
          
            display: flex;
            justify-content: center;
            align-items: center;
            animation: backgroundAnimation 10s infinite alternate;
        }

        @keyframes backgroundAnimation {
            0% {
                background: linear-gradient(45deg, #2980b9, #2ecc71);
            }
            50% {
                background: linear-gradient(45deg, #2ecc71, #2980b9);
            }
            100% {
                background: linear-gradient(45deg, #3498db, #2ecc71);
            }
        }

        #map {
            height: 400px;
            width: 100%;
            margin-bottom: 20px;
        }

        form {
            background: rgb(0,0,0); /* White background with transparency */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 300px; /* Set a fixed width for the form */
        }

        label {
            display: block;
            color: white;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select,
        textarea {
            width: 100%; /* Full width */
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #2ecc71; /* Button color */
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; /* Full width */
            font-size: 16px;
        }

        button:hover {
            background-color: #27ae60; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <center>
    <h2>Register Your Agency</h2>
    <form action="register_action.php" method="POST">
        <label for="name">Agency Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number">

        <label for="type">Agency Type:</label>
        <select name="type" id="type" required>
            <option value="Government">Government</option>
            <option value="Private">Private</option>
            <option value="NGO">NGO</option>
        </select>

        <label for="expertise">Expertise:</label>
        <textarea id="expertise" name="expertise"></textarea>

        <label for="resources">Resources:</label>
        <textarea id="resources" name="resources"></textarea>

        <label for="location">Select Location:</label>
        <div id="map"></div>
        <input type="hidden" id="latitude" name="latitude" required>
        <input type="hidden" id="longitude" name="longitude" required>

        <button type="submit">Register</button>
    </form>
    </center>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Initialize the map and set its view
        var map = L.map('map').setView([20.5937, 78.9629], 5); // Default to India's coordinates

        // Set up the OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        var marker;

        // Add click event listener on the map
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // If marker exists, remove it
            if (marker) {
                map.removeLayer(marker);
            }

            // Add marker to the clicked location
            marker = L.marker([lat, lng]).addTo(map);

            // Set the value of hidden fields
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });
    </script>
</body>
</html>
