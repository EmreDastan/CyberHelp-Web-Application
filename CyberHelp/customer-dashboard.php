<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: customer-login.php");
    exit();
}

// Database credentials
$host = 'localhost';
$db_name = 'cyberhelp';
$username = 'root';
$password = '';

// Establish a connection to the database
$conn = new mysqli($host, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Display order status message if available
if (isset($_SESSION['order_status'])) {
    $orderStatus = ($_SESSION['order_status'] === 'success') ? 'Order placed successfully!' : 'Order placement failed. Please try again.';
    echo '<div class="order-status">' . htmlspecialchars($orderStatus, ENT_QUOTES) . '</div>';
    // Remove the order status from the session to avoid displaying it again on page refresh
    unset($_SESSION['order_status']);
}

// Close the connection
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberHelp Customer Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax.com/cdnjs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General styles */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #03303d, #111111); /* Gradient background */
            color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        /* Sidebar styles */
        .sidebar {
            width: 20%;
            background: linear-gradient(to bottom right, #03303d, #191919); /* Different tones */
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            bottom: 0;
        }

        /* Sidebar links */
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #5b5b5b; /* Slightly lighter grey */
        }

        /* Logout button styles */
        .logout-btn {
            background: linear-gradient(to bottom right, #00ade0, #03303d); /* Matching body gradient */
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #546e7a; /* Darker blue-grey */
        }

        /* Upper bar styles */
        .upper-bar {
            width: 80%; /* Matches the width of the main content area */
            margin-left: 22.1%; /* Aligns with the main content area */
            background: linear-gradient(to bottom right, #03303d, #121212); /* Gradient background */
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            z-index: 10;
        }

        /* Upper bar logo styles */
        .upper-bar .logo {
            display: flex;
            align-items: center;
        }

        .upper-bar .logo img {
            max-width: 80px; /* Adjusts the logo width */
            height: auto; /* Maintains aspect ratio */
        }

        /* Upper bar text styles */
        .upper-bar-text {
            font-size: 20px; /* Adjust font size */
            color: #f5f5f5; /* Matching the overall text color */
            margin-left: 22.1px; /* Spacing between logo and text */
            margin-right: 80px;
        }

        /* Container styles */
        .container {
            width: 80%;
            margin-left: 20%;
            margin-top: 60px; /* Account for upper bar height */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: linear-gradient(to bottom right, #03303d, #121212); /* Matching body gradient */
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        /* Heading styles */
        h1 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #00bcd4; /* Bright cyan */
        }

        /* Button styles */
        .button {
            display: block;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 500;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            width: 80%; /* Larger width */
            height: 60px; /* Rectangular shape */
            margin: 10px 0; /* Margin between buttons */
            background: #37474f; /* Dark blue-grey */
        }

        /* Button colors */
        .button.view-orders {
            background: linear-gradient(to bottom right, #00ade0, #03303d); /* Matching body gradient */
            
        }

        .button.defensive {
            background: linear-gradient(to bottom right, #00ade0, #03303d); /* Matching body gradient */
        }

        .button.offensive {
            background: linear-gradient(to bottom right, #00ade0, #03303d); /* Matching body gradient */
        }

        .button.custom {
            background: linear-gradient(to bottom right, #00ade0, #03303d); /* Matching body gradient */
        }

        /* Button container */
        .button-container {
            display: flex;
            flex-direction: column;
            width: 80%; /* Width for alignment */
            margin-top: 20px;
        }

        /* Button hover effect */
        .button:hover {
            box-shadow: 0 0 10px rgba(0, 188, 212, 0.3), 0 0 20px rgba(0, 188, 212, 0.3);
        }

        /* Information panel styles */
        .info-panel {
            padding: 20px;
            border-radius: 8px;
            background: #333333; /* Slightly lighter grey */
            margin-bottom: 10px;
            color: #f5f5f5;
        }
    </style>
</head>

<body>
    <!-- Sidebar navigation -->
    <div class="sidebar">
        <h2>CyberHelp</h2>
        <!-- Support link -->
        <!-- <a href="contact-support.php"><i class="fas fa-headset"></i> Support</a> -->
        <!-- Social media links -->
        <a href="https://twitter.com/thegalactical" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
        <a href="https://www.linkedin.com/in/yunusemredastan/" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a>
        <a href="https://github.com/EmreDastan" target="_blank"><i class="fab fa-github"></i> Github</a>
        <!-- Logout button -->
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>

    <!-- Upper bar -->
<div class="upper-bar">
    <a href="customer-dashboard.php" class="logo">
        <img src="images/logo.png" alt="Your Logo">
    </a>
    <div class="upper-bar-text">
        CYBERHELP SECURITY SERVICES
    </div>
</div>


    <!-- Main content container -->
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?>!</h1>
        <!-- Information panel -->
        <!-- <div class="info-panel">
            <p>System Status: Secure</p>
            <p>Latest Alert: No alerts at this time.</p>
        </div> -->
        <!-- Button layout -->
        <div class="button-container">
            <a href="active-orders.php" class="button view-orders"><i class="fas fa-eye"></i> View Active Orders</a>
            <a href="defensive-security.php" class="button defensive"><i class="fas fa-shield-alt"></i> Defensive Security</a>
            <a href="offensive-security.php" class="button offensive"><i class="fas fa-bug"></i> Offensive Security</a>
            <a href="custom-security.php" class="button custom"><i class="fas fa-cogs"></i> Custom Security</a>
        </div>
    </div>
</body>

</html>









