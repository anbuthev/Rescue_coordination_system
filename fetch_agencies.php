<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rescue Agency Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 600px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h2>Rescue Agencies Map</h2>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</body>
</html>
<?php
require 'db_connect.php';

$sql = "SELECT name, location, expertise FROM agencies";
$result = $conn->query($sql);

$agencies = array();

while($row = $result->fetch_assoc()) {
    // Assuming the location is stored as "latitude,longitude"
    $location = explode(",", $row['location']);
    $agency = array(
        'name' => $row['name'],
        'lat' => floatval($location[0]),
        'lng' => floatval($location[1]),
        'expertise' => $row['expertise']
    );
    array_push($agencies, $agency);
}

echo json_encode($agencies);

$conn->close();
?>
