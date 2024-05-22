<?php
include 'connection.php';
session_start();

if (isset($_POST['place_order'])) {
    // Retrieve user information
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $state = mysqli_real_escape_string($conn, $_POST['state']); // Assuming state is from the form

    // Check if user already exists in users table
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists, retrieve user_id
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
    } else {
        // User does not exist, insert new user and retrieve user_id
        $is_guest = 1; // Set the user as a guest
        $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, phone_number, shipping_address, state, is_guest) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $state, $is_guest);
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
        } else {
            // Handle insertion error
            die("Error inserting user: " . $conn->error);
        }
    }

    // Retrieve order information
    $order_cost = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
    $order_status = "on_hold";
    $order_date = date('Y-m-d H:i:s');

    // Insert order into orders table
    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, order_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $order_cost, $order_status, $user_id, $order_date);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Insert order items into order_items table
    foreach ($_SESSION['cart'] as $product) {
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];

        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssi", $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity);
        $stmt->execute();
    }

    // Redirect to payment page with order_id
    header('Location: ../payment.php?order_id=' . $order_id);
} else {
    // Redirect to index if place_order not set
    header('location: index.php');
}
?>
