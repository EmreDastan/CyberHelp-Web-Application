<?php
session_start();

// Database credentials
$host = 'localhost';
$db_name = 'cyberhelp';
$username = 'root';
$password = '';

// Establish connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch order details
if (isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']);
    $sql = "SELECT orders.id, order_date, order_details, username, order_type
            FROM orders
            INNER JOIN customers ON orders.customer_id = customers.id
            WHERE orders.id = ? AND customers.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $orderId, $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $orderDetails = $result->fetch_assoc();
        echo json_encode($orderDetails);
    } else {
        echo json_encode(['error' => 'Order not found or access denied']);
    }

    $stmt->close();
}

$conn->close();
?>
