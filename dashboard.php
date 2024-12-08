<?php
include('header.php');
session_start();
if (!isset($_SESSION['agency_id'])) {
    header("Location: login.php");
    exit();
}
require 'db_connect.php';

// Fetch all agencies from the database
$sql = "SELECT name, latitude, longitude, expertise, resources, contact_number FROM agencies";
$result = $conn->query($sql);

$agencies = array();

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
    <title>Agency Dashboard</title>
    <!-- Leaflet CSS (for map integration) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- CSS for styling, animations, and responsive layout -->
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2980b9, #2ecc71);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h2 {
            color: #fff;
            text-align: center;
            font-size: 2.5rem;
            animation: fadeIn 2s ease-in-out;
            margin: 20px 0;
        }

        /* Main container for the grid */
        .container {
            display: grid;
            grid-template-columns: repeat(6, 1fr); /* 6 columns */
            gap: 20px; /* Spacing between items */
            width: 100%;
            max-width: 1200px;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Styling for each menu item */
        .menu-item {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background-color: #2ecc71;
            transform: translateY(-5px);
        }

        .menu-item a {
            text-decoration: none;
            color: #2980b9;
            font-size: 1.2rem;
        }

        .menu-item:hover a {
            color: white;
        }


            .menu-item {
                font-size: 1rem;
            }
        

        /* Animation for fading in the page elements */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(0.95);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>

    <h2>Welcome to the Agency Dashboard</h2>

    <div class="container">
        <!-- Divs to replace ul and li -->
        <div class="menu-item"><a href="map.php">Maps</a></div>
        <div class="menu-item"><a href="profile.php">Profile</a></div>
        <div class="menu-item"><a href="send_alert.php">Send Alert</a></div>
        <div class="menu-item"><a href="fetch_alerts.php">Received Alerts</a></div>
        <div class="menu-item"><a href="send_message.php">Send Message</a></div>
        <div class="menu-item"><a href="fetch_messages.php">Received Messages</a></div>
        <div class="menu-item"><a href="report_incident.php">Report Incident</a></div>
        <div class="menu-item"><a href="manage_incidents.php">Manage Incidents</a></div>
        <div class="menu-item"><a href="request_resource.php">Request Resource</a></div>
        <div class="menu-item"><a href="allocate_resource.php">Allocate Resources</a></div>
        <div class="menu-item"><a href="manage_resources.php">Manage Resources</a></div>
        <div class="menu-item"><a href="overall_report.php">Overall Reports</a></div>
    
    </div>

</body>
</html>
