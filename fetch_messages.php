<?php
include('header.php');
session_start();
require 'db_connect.php';

$receiver_agency_id = $_SESSION['agency_id'];

$sql = "SELECT a.name, m.message, m.timestamp 
        FROM messages m 
        JOIN agencies a ON m.sender_agency_id = a.id 
        WHERE m.receiver_agency_id = ?
        ORDER BY m.timestamp DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $receiver_agency_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #2980b9;
            color: #fff;
        }

        .container {
            max-width: 800px; /* Maximum width for the message container */
            margin: 50px auto; /* Centering with auto margins */
            padding: 20px;
            background:rgb(13, 41, 47); /* Semi-transparent background */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Shadow effect */
        }

        .message {
            margin-bottom: 20px; /* Space between messages */
            padding: 10px;
            background: rgba(255, 255, 255, 0.2); /* Slightly brighter background for messages */
            border-radius: 5px; /* Rounded corners for messages */
        }

        strong {
            color: #2ecc71; /* Color for sender name */
        }

        small {
            color: #bdc3c7; /* Color for timestamp */
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Received Messages</h2>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<div class='message'>
                    <strong>From " . htmlspecialchars($row['name']) . ":</strong><br>" . 
                    htmlspecialchars($row['message']) . "<br>
                    <small>" . htmlspecialchars($row['timestamp']) . "</small>
                  </div>";
        }
        ?>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
