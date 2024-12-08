<?php
include('header.php');
require 'db_connect.php';

$sql = "SELECT a.name, al.title, al.message, al.timestamp 
        FROM alerts al 
        JOIN agencies a ON al.agency_id = a.id 
        WHERE al.status = 'open'
        ORDER BY al.timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Alerts</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #2980b9;
            color: #fff;
        }

        .container {
            max-width: 800px; /* Maximum width for the alert container */
            margin: 50px auto; /* Centering with auto margins */
            padding: 20px;
            background: rgba(255, 255, 255, 0.1); /* Semi-transparent background */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Shadow effect */
        }

        .alert {
            margin-bottom: 20px; /* Space between alerts */
            padding: 15px;
            background: rgb(13, 41, 47); /* Slightly brighter background for alerts */
            border-radius: 5px; /* Rounded corners for alerts */
        }

        strong {
            color: #2ecc71; /* Color for agency name */
        }

        small {
            color: #bdc3c7; /* Color for timestamp */
        }

        h2 {
            text-align: center; /* Center align the title */
            color: #fff; /* Title color */
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Fetch Alerts</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='alert'>
                        <strong>" . htmlspecialchars($row['name']) . "</strong>: " . 
                        htmlspecialchars($row['title']) . "<br>" . 
                        htmlspecialchars($row['message']) . "<br>
                        <small>" . htmlspecialchars($row['timestamp']) . "</small>
                      </div>";
            }
        } else {
            echo "<p>No open alerts available.</p>";
        }
        ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>
