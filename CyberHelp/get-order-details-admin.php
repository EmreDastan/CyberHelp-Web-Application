<?php
// Start the session
session_start();

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

// Check if order ID is provided
if (isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Prepare SQL statement to fetch order details
    $sql = "SELECT orders.id, order_date, order_details, username, order_type, statuss
            FROM orders
            INNER JOIN customers ON orders.customer_id = customers.id
            WHERE orders.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch order details
        $row = $result->fetch_assoc();
        // Close statement
        $stmt->close();
        // Encode order details as JSON and output
        echo json_encode($row);
    } else {
        // No order found with the provided ID
        echo json_encode(['error' => 'Order not found']);
    }
} else {
    // No order ID provided
    echo json_encode(['error' => 'Order ID not provided']);
}

// Close the database connection
$conn->close();
?>
