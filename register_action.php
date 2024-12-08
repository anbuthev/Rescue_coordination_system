<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $contact_number = htmlspecialchars(trim($_POST['contact_number']));
    $expertise = htmlspecialchars(trim($_POST['expertise']));
    $resources = htmlspecialchars(trim($_POST['resources']));
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $type = $_POST['type'];
    // Validate that latitude and longitude are provided
    if (empty($latitude) || empty($longitude)) {
        die("Location coordinates are required.");
    }

    $stmt = $conn->prepare("INSERT INTO agencies (name, email, password, contact_number, expertise, resources, latitude, longitude,type) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssssdds", $name, $email, $password, $contact_number, $expertise, $resources, $latitude, $longitude,$type);

    if ($stmt->execute()) {
        echo "Agency registered successfully!";
        // Redirect to login or dashboard
        header("Location: login.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: register.php");
    exit();
}
?>
