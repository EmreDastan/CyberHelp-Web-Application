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

// Constants for pagination
$perPage = 5; // Number of orders per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cyberhelp</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General styles */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #03303d, #191919);
            color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Upper bar styles */
        .upper-bar {
            width: 100%;
            background: linear-gradient(to bottom right, #03303d, #191919);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            z-index: 10;
        }

        /* Upper bar text styles */
        .upper-bar-text {
            font-size: 20px;
            color: #f5f5f5;
            margin-left: 22.1px;
            margin-right: 80px;
        }

        /* Upper bar logo styles */
        .upper-bar .logo {
            display: flex;
            align-items: center;
        }

        .upper-bar .logo img {
            max-width: 80px;
            height: auto;
        }

        /* Active orders container */
        .active-orders-container {
            width: 80%;
            margin: auto;
            margin-top: 80px;
            padding: 20px;
            border-radius: 10px;
            background: linear-gradient(to bottom right, #03303d, #191919);
            color: #f5f5f5;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            box-sizing: border-box;
            text-align: center;
        }

        /* Active orders heading */
        .active-orders-heading {
            margin-bottom: 20px;
            color: #00bcd4;
        }

        /* Order cards container */
        .order-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        /* Order card styles */
        .order-card {
            padding: 20px;
            background-color: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .order-card:hover {
            transform: scale(1.03);
        }

        /* Order title */
        .order-title {
            font-size: 20px;
            font-weight: bold;
            color: #00bcd4;
        }

        /* Order details */
        .order-details {
            margin-top: 10px;
            color: #f5f5f5;
        }

        /* Order actions */
        .order-actions {
            margin-top: 10px;
            display: flex;
            justify-content: space-around;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 10px;
            margin: 0 5px;
            text-decoration: none;
            color: #fff;
            background-color: #00bcd4;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #0087a3;
        }

        .pagination .current {
            background-color: #0087a3;
        }

        /* Logout button styles */
        .logout-btn {
            background-color: #00bcd4;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 35px; /* Adjust the margin-right as needed */
        }

        .logout-btn:hover {
            background-color: #0087a3;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background-color: #1e
            .modal-content {
            background-color: #1e1e1e;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- Upper bar -->
    <div class="upper-bar">
        <a href="admin-dashboard.php" class="logo">
            <img src="images/logo.png" alt="Your Logo">
        </a>
        <div class="upper-bar-text">
            CYBERHELP SECURITY SERVICES
        </div>
        <!-- Logout button -->
        <form action="admin-logout.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>


    <!-- Active orders section -->
    <section class="active-orders-container">
        <h2 class="active-orders-heading">Received Orders</h2>

        <!-- Order cards container -->
        <div class="order-cards-container">
            <?php
            // Using prepared statement to fetch active orders
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT orders.id, order_date, SUBSTRING(order_details, 1, 50) AS short_details, username, order_type, statuss
                    FROM orders
                    INNER JOIN customers ON orders.customer_id = customers.id
                    ORDER BY orders.order_date DESC
                    LIMIT ?, ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ii', $offset, $perPage);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                die("Error in SQL query: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="order-card" data-order-id="' . htmlspecialchars($row['id']) . '">';
                    echo '<div class="order-title">Order #' . htmlspecialchars($row['id']) . '</div>';
                    echo '<div class="order-details">Date: ' . htmlspecialchars($row['order_date']) . '</div>';
                    echo '<div class="order-details">Details: ' . htmlspecialchars($row['short_details']) . '</div>';
                    echo '<div class="order-details">Customer: ' . htmlspecialchars($row['username']) . '</div>';
                    echo '<div class="order-details">Order Type: ' . htmlspecialchars($row['order_type']) . '</div>';
                    echo '<div class="order-details">Status: ' . htmlspecialchars($row['statuss']) . '</div>';
                    echo '<div class="order-actions">';
                    echo '<form method="post" action="process-admin-action.php">';
                    echo '<input type="hidden" name="order_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="action" value="approve">Approve</button>';
                    echo '<button type="submit" name="action" value="reject">Reject</button>';
                    echo '<button type="submit" name="action" value="remove">Remove</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No received order found.</p>';
            }

            $stmt->close();
            ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            // Calculate total pages for pagination
            $totalOrders = $result->num_rows;
            $totalPages = ceil($totalOrders / $perPage);
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '"' . ($i == $page ? ' class="current"' : '') . '>' . $i . '</a>';
            }
            ?>
        </div>
    </section>

    <!-- The Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalDetails"></div>
        </div>
    </div>

    <script>
        // Modal script
        const modal = document.getElementById("orderModal");
        const modalDetails = document.getElementById("modalDetails");
        const span = document.getElementsByClassName("close")[0];

        document.querySelectorAll('.order-card').forEach(card => {
    card.addEventListener('click', function () {
        const orderId = this.getAttribute('data-order-id');

        fetch(`get-order-details-admin.php?id=${orderId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    modalDetails.innerHTML = `<p>Error: ${data.error}</p>`;
                } else {
                    modalDetails.innerHTML = `
                        <h2>Order #${data.id}</h2>
                        <p><strong>Date:</strong> ${data.order_date}</p>
                        <p><strong>Details:</strong> ${data.order_details}</p>
                        <p><strong>Customer:</strong> ${data.username}</p>
                        <p><strong>Order Type:</strong> ${data.order_type}</p>
                        <p><strong>Status:</strong> ${data.statuss}</p>
                    `;
                }
                modal.style.display = "block";
            })
            .catch(error => console.error('Error fetching order details:', error));
    });
});


        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>

</html>
