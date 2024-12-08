<?php
 include('header.php');

session_start();
if (!isset($_SESSION['agency_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

$agency_id = $_SESSION['agency_id'];

// Fetch the agency details from the database
$stmt = $conn->prepare("SELECT name, email, contact_number, expertise, resources, latitude, longitude FROM agencies WHERE id = ?");
$stmt->bind_param("i", $agency_id);
$stmt->execute();
$stmt->bind_result($name, $email, $contact_number, $expertise, $resources, $latitude, $longitude);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Profile</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #780c14;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-container h2 {
            text-align: center;
        }
        .profile-container label {
            font-weight: bold;
        }
        .profile-container .info {
            margin-bottom: 15px;
        }
        #update-location-map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
            display: none; /* Initially hidden */
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Agency Profile</h2>
        <div class="info">
            <label for="name">Agency Name:</label>
            <p id="name"><?php echo htmlspecialchars($name); ?></p>
        </div>
        <div class="info">
            <label for="email">Email:</label>
            <p id="email"><?php echo htmlspecialchars($email); ?></p>
        </div>
        <div class="info">
            <label for="contact_number">Contact Number:</label>
            <p id="contact_number"><?php echo htmlspecialchars($contact_number); ?></p>
        </div>
        <div class="info">
            <label for="expertise">Expertise:</label>
            <p id="expertise"><?php echo htmlspecialchars($expertise); ?></p>
        </div>
        <div class="info">
            <label for="resources">Resources:</label>
            <p id="resources"><?php echo htmlspecialchars($resources); ?></p>
        </div>
        <div class="info">
            <label for="location">Location:</label>
            <div id="map"></div>
        </div>
        <button id="update-location-btn">Update My Location</button>
        <div id="update-location-map"></div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 13);

        // Set up the OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        // Add a marker at the agency's location
        var marker = L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map);
        marker.bindPopup("<strong><?php echo htmlspecialchars($name); ?></strong><br><?php echo htmlspecialchars($contact_number); ?><br><?php echo htmlspecialchars($resources); ?>").openPopup();

        // Update Location Button Logic
        var updateMap;

        document.getElementById('update-location-btn').addEventListener('click', function() {
            var mapContainer = document.getElementById('update-location-map');
            mapContainer.style.display = 'block';
            
            // Only initialize the map once to avoid multiple initializations
            if (!updateMap) {
                updateMap = L.map('update-location-map').setView([20.5937, 78.9629], 5); // Default view

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                }).addTo(updateMap);
            }

            var updateMarker;

            updateMap.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                if (updateMarker) {
                    updateMap.removeLayer(updateMarker);
                }

                updateMarker = L.marker([lat, lng]).addTo(updateMap);

                if (confirm("Do you want to set this as your new location?")) {
                    fetch('update_location.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ latitude: lat, longitude: lng })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.status === 'success') {
                            location.reload(); // Reload the page to update the main map
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        });
    </script>
</body>
</html>
