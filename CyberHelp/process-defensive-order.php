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

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $orderDate = $_POST['order-date'] ?? '';
    $orderDetails = $_POST['order-details'] ?? '';

    // Check if order data is not empty
    if (!empty($orderDate) && !empty($orderDetails)) {
        // Set order type for defensive page
        $orderType = 'Defensive';

        // Insert order data into the database with the correct customer_id and order_type
        $query = "INSERT INTO orders (customer_id, order_date, order_details, order_type) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Assuming $_SESSION['id'] contains the customer's ID
        $stmt->bind_param('isss', $_SESSION['id'], $orderDate, $orderDetails, $orderType);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Order placed successfully
            $_SESSION['order_status'] = 'success';
        } else {
            // Order placement failed
            $_SESSION['order_status'] = 'failure';
        }

        // Redirect back to the dashboard
        header("Location: customer-dashboard.php");
        exit();
    }
}

// If the form data is not submitted or incomplete, redirect back to the order page
header("Location: defensive-security.php");
exit();
?>
