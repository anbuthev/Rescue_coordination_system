<?php
include('header.php');
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agency_id = $_SESSION['agency_id']; // Assume the user is logged in and agency_id is stored in session
    $title = $_POST['title'];
    $message = $_POST['message'];

    $sql = "INSERT INTO alerts (agency_id, title, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $agency_id, $title, $message);
    
    if ($stmt->execute()) {
        echo "Alert sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Dashboard</title>
    </head>
    <body>
    <center><form action="send_alert.php" method="post">
        <br>
    <label for="title">Alert Title:</label>
    <input type="text" name="title" id="title" required>
<br><br>
    <label for="message">Alert Message:</label>
    <textarea name="message" id="message" required></textarea>
<br><br>
    <input type="submit" value="Send Alert">
    </center>
</form>
    </body>
</html>
