<?php
session_start(); // Start the session

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

// Retrieve values from the login form
$username = $_POST['customerUsername'];
$password = $_POST['customerPassword'];

// Prepare and execute the SQL query
$query = "SELECT id, username FROM customers WHERE username = ? AND pass = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $username, $password); // No hashing

$stmt->execute();
$stmt->store_result();

// Debugging: Output the SQL query
echo "SQL Query: $query <br>";

// Debugging: Output the number of rows returned
echo "Number of Rows: " . $stmt->num_rows . "<br>";

// Check if the user exists
if ($stmt->num_rows > 0) {
    // Debugging: Output the username
    echo "User found: $username <br>";

    // User found, set session variables and redirect to the dashboard
$stmt->bind_result($userId, $userUsername);
$stmt->fetch();
$_SESSION['id'] = $userId;
$_SESSION['username'] = $userUsername;
header("Location: customer-dashboard.php");
exit();
 // Ensure that no further code is executed after the redirection
} else {
    // Debugging: Output an error message
    echo "User not found: $username <br>";

    // User not found, set an error message and redirect with the error parameter
    $_SESSION['error_message'] = "Invalid username or password. Please try again.";
    header("Location: customer-login.php");
    exit();
}


// Close the statement and database connection
$stmt->close();
$conn->close();

?>
