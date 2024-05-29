<?php
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

if(isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Prepare and execute SQL query to fetch order details including statuss
    $sql = "SELECT orders.id, order_date, order_details, username, order_type, statuss
            FROM orders
            INNER JOIN customers ON orders.customer_id = customers.id
            WHERE orders.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the order exists
    if($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        // Return order details as JSON response
        echo json_encode($order);
    } else {
        echo json_encode(array('error' => 'Order not found'));
    }

    $stmt->close();
} else {
    echo json_encode(array('error' => 'Order ID not provided'));

    $stmt->close();
}

$conn->close();
?>
