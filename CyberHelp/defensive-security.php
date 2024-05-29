<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header("Location: customer-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Defensive Security Order - CyberHelp</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax.com/cdnjs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General styles */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #03303d, #191919); /* Different tones */
            color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Upper bar styles */
        .upper-bar {
            width: 100%; /* Full width of the page */
            background: linear-gradient(to bottom right, #03303d, #191919); /* Different tones */
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

        /* Order container */
        .order-container {
            width: 80%; /* Responsive width */
            margin: auto;
            margin-top: 80px; /* Adjusts for upper bar height */
            padding: 20px;
            border-radius: 10px;
            background: linear-gradient(to bottom right, #03303d, #191919); /* Different tones */
            color: #f5f5f5;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            box-sizing: border-box;
            text-align: center;
        }

        /* Order heading */
        .order-heading {
            margin-bottom: 20px;
            color: #00bcd4; /* Bright cyan */
        }

        /* Order form */
        .order-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0 20px;
        }

        /* Form group */
        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }

        /* Form group labels */
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #00bcd4; /* Bright cyan */
        }

        /* Form inputs and textareas */
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #333;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Order button */
        .order-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to bottom right, #00ade0, #03303d);
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .order-btn:hover {
            background-color: #0087a3; /* Darker cyan */
        }

        /* Back to dashboard link */
        .back-to-dashboard-link {
            margin-top: 20px;
        }

        .back-to-dashboard-link a {
            text-decoration: none;
            color: #00bcd4;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Upper bar -->
    <div class="upper-bar">
        <a href="customer-dashboard.php" class="logo">
            <img src="images/logo.png" alt="Your Logo">
        </a>
        <div class="upper-bar-text">
            CYBERHELP SECURITY SERVICES
        </div>
    </div>

    <!-- Order container -->
    <section class="order-container">
        <h2 class="order-heading">Order Defensive Security</h2>

        <!-- Order form -->
        <form class="order-form" action="process-defensive-order.php" method="post">
            <div class="form-group">
                <label for="order-date">Select Date:</label>
                <input type="date" name="order-date" id="order-date" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label for="order-details">Provide Details:</label>
                <textarea name="order-details" id="order-details" rows="4" required></textarea>
            </div>
            <button type="submit" class="order-btn">Place Order</button>
        </form>

        <!-- Back to Dashboard Link -->
        <p class="back-to-dashboard-link">
            <a href="customer-dashboard.php">Back to Dashboard</a>
        </p>
    </section>

</body>

</html>
