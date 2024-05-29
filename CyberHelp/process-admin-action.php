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

// Check if the action is set
if(isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // Handle approve action
    if($action === 'approve') {
        // Get the order ID
        $order_id = $_POST['order_id'];
        
        // Update the order status to 'Approved' in the database
        $sql = "UPDATE orders SET statuss='Approved' WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $order_id);
        if ($stmt->execute()) {
            echo json_encode(array('message' => 'Order approved successfully!'));
        } else {
            echo json_encode(array('error' => 'Error approving order: ' . $conn->error));
        }
        $stmt->close();
    }
    
    // Handle reject action
    elseif($action === 'reject') {
        // Get the order ID
        $order_id = $_POST['order_id'];
        
        // Update the order status to 'Rejected' in the database
        $sql = "UPDATE orders SET statuss='Rejected' WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $order_id);
        if ($stmt->execute()) {
            echo json_encode(array('message' => 'Order rejected successfully!'));
        } else {
            echo json_encode(array('error' => 'Error rejecting order: ' . $conn->error));
        }
        $stmt->close();
    }
    
    // Handle remove action
    elseif($action === 'remove') {
        // Get the order ID
        $order_id = $_POST['order_id'];
        
        // Delete the order from the database
        $sql = "DELETE FROM orders WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $order_id);
        if ($stmt->execute()) {
            echo json_encode(array('message' => 'Order removed successfully!'));
        } else {
            echo json_encode(array('error' => 'Error removing order: ' . $conn->error));
        }
        $stmt->close();
    }
    
    // Invalid action
    else {
        echo json_encode(array('error' => 'Invalid action!'));
    }
} else {
    echo json_encode(array('error' => 'Action not set!'));
}
?>
