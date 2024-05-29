<?php
// Replace these with your actual database credentials
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

// Retrieve values from the registration form
$username = $_POST['customerUsername'];
$password = $_POST['customerPassword'];

// Prepare and execute the SQL query for registration
$query = "INSERT INTO customers (username, pass) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $username, $password); // No hashing

if ($stmt->execute()) {
    echo "Registration successful!";

    // Redirect to the login page after successful registration
    header("Location: customer-login.php");
    exit();
} else {
    echo "Registration failed. Please try again.";
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
