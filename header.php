<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Header</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #2980b9;
            color: #fff;
        }

        header {
            display: flex;
            justify-content: space-between; /* Space between home and logout button */
            align-items: center;
            padding: 10px 20px;
            background-color: #2ecc71;
            position: relative; /* Position relative for any absolute positioning inside */
        }

        .home-icon {
            display: flex;
            align-items: center; /* Center the icon vertically */
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }

        .logout-button {
            display: flex;
            align-items: center; /* Center the icon vertically */
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            margin-left: auto; /* Pushes the logout button to the right */
        }

        .logout-button:hover {
            color: #ff4757;
        }

        /* Style for the icons */
        .home-icon i, .logout-button i {
            font-size: 24px; /* Increased icon size */
            margin-right: 5px; /* Space between icon and text */
        }
    </style>
</head>
<body>
    <header>
        <a href="dashboard.php" class="home-icon" title="Go to Dashboard">
            <i class="fas fa-home"></i>
        </a>
        <a href="logout.php" class="logout-button" title="Logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </header>
</body>
</html>
