<?php
session_start(); // Start the session

// Check if there is an error message
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']); // Clear the error message

// Check if the user is already logged in and redirect to the dashboard
if (isset($_SESSION['username'])) {
    header("Location: customer-dashboard.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - CyberHelp</title>
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

        /* Login container */
        .login-container {
            width: 600px; /* Fixed width */
            padding: 50px;
            background: linear-gradient(to bottom right, #03303d, #191919); /* Different tones */
            color: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            box-sizing: border-box;
            margin: auto;
            margin-top: 100px; /* Adjust for vertical centering */
            text-align: center;
        }

        /* Login heading */
        .login-heading {
            color: #00bcd4; /* Bright cyan */
            margin-bottom: 20px;
        }

        /* Login form */
        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
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

        /* Form inputs */
        .form-group input {
            width: 100%;
            padding: 15px;
            border: 1px solid #333;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Login button */
        .login-btn {
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

        .login-btn:hover {
            background-color: #0087a3; /* Darker cyan */
        }

        /* Error message */
        .error-message {
            color: #ff3333;
            margin-top: 10px;
            text-align: center;
        }

        /* Register link */
        .register-link {
            margin-top: 20px;
            color: #00bcd4; /* Bright cyan */
            text-align: center;
        }

        .register-link a {
            color: #00bcd4;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var errorMessage = "<?php echo $error_message; ?>";
            if (errorMessage) {
                var errorMessageElement = document.getElementById('error-message');
                errorMessageElement.innerHTML = errorMessage;
                errorMessageElement.style.display = 'block';
            }
        });
    </script>
</head>

<body>

    <!-- Login container -->
    <div class="login-container">
        <h2 class="login-heading">Customer Login</h2>

        <!-- Display error message -->
        <div id="error-message" class="error-message"></div>

        <!-- Login form -->
        <form class="login-form" action="process-login.php" method="post">
            <div class="form-group">
                <label for="customerUsername">Username</label>
                <input type="text" name="customerUsername" id="customerUsername" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="customerPassword">Password</label>
                <input type="password" name="customerPassword" id="customerPassword" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>

        <!-- Register link -->
        <p class="register-link">
            Don't have an account? <a href="register.html">Register here</a>
        </p>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- Include your custom scripts here -->

</body>

</html>

