<?php
include('header.php');

session_start();
require 'db_connect.php';

// Ensure the session contains the sender's agency ID or agency name.
if (!isset($_SESSION['agency_id'])) {
    // If the agency ID is not set, redirect to login page or handle the error.
    header("Location: login.php");
    exit();
}

$sender_agency_id = $_SESSION['agency_id'];

// Fetch the list of agencies to populate the dropdown
$sql = "SELECT id, name FROM agencies";
$result = $conn->query($sql);

$options = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
    }
} else {
    echo "No agencies found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
</head>
<body>
    <center>
    <form action="send_message.php" method="post">
        <br>
        <label for="receiver_agency_id">Select Agency to Message:</label>
        <select name="receiver_agency_id" id="receiver_agency_id" required>
            <?php echo $options; ?>
        </select>
<br><br>
        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>
<br><br>
        <input type="submit" value="Send Message">
</center></form>
</body>
</html>

<?php
// The following PHP script should be placed in a separate file, send_message.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db_connect.php';

    $sender_agency_id = $_SESSION['agency_id'];
    $receiver_agency_id = $_POST['receiver_agency_id'];
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (sender_agency_id, receiver_agency_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $sender_agency_id, $receiver_agency_id, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
