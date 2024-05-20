<?php
include 'connection.php';
session_start();

if (isset($_POST['place_order'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $order_cost = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
    $order_status = "on_hold";
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isissss", $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);
    $stmt->execute();

    $order_id = $stmt->insert_id;

    foreach ($_SESSION['cart'] as $product) {
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];

        $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
        $stmt1->execute();
    }

    header('Location: ../payment.php?order_id=' . $order_id);
} else {
    header('location: index.php');
}
?>
