<?php
require 'db_connect.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM agencies WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            // Start a session and set user ID
            session_start();
            $_SESSION['agency_id'] = $id;
            // Redirect to dashboard or agency management page
            header("Location: dashboard.php");
            exit; // Ensure script stops after redirect
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "No user found with this email!";
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
    <title>Agency Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #2980b9, #2ecc71);
            color: #fff;
            font-family: Arial, sans-serif;
        }
        form {
            background: rgb(0, 0, 0);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #27ae60; /* Button color */
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #219653; /* Darker green on hover */
        }
        .error {
            color: #e74c3c; /* Red color for error messages */
        }
    </style>
</head>
<body>
    <form action="login.php" method="POST">
        <h2>Agency Login</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
<br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
