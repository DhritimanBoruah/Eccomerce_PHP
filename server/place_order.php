<?php
include 'connection.php';
session_start();

if (isset($_POST['place_order'])) {
    // Get user info
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '';
    $city = isset($_POST['city']) ? mysqli_real_escape_string($conn, $_POST['city']) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : '';
    $order_cost = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
    $order_status = "on_hold";
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    // Issue new order and store order in the database
    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isissss", $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);
    $stmt->execute();

    // Get the order ID of the newly inserted order
    $order_id = $stmt->insert_id;

    // Iterate through the products in the cart and insert them into the order_items table
    foreach ($_SESSION['cart'] as $product) {
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];

        // Insert the product into the order_items table
        $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
        $stmt1->execute();

        // Check for errors
        if ($stmt1->errno) {
            echo "Error inserting order item: " . $stmt1->error;
            // Handle the error accordingly, such as logging it or displaying a message to the user
        }
    }

    // Redirect to the payment page with a success message
    header('location: ../payment.php?order_status=Order placed Successfully!');
} else {
    // Handle the case where 'place_order' is not set
    header('location: index.php');
}
