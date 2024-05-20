<?php
include 'server/connection.php';
session_start();

if (isset($_POST['razorpay_payment_id']) && isset($_POST['order_id']) && isset($_POST['amount'])) {
    $razorpay_payment_id = mysqli_real_escape_string($conn, $_POST['razorpay_payment_id']);
    $order_id = intval($_POST['order_id']);
    $amount = intval($_POST['amount']) / 100; // Convert to main currency unit
    $payment_date = date('Y-m-d H:i:s');

    // Update the order status to "paid"
    $stmt = $conn->prepare("UPDATE orders SET order_status = 'paid' WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    if ($stmt->execute()) {
        // Insert payment details into the payments table
        $stmt = $conn->prepare("INSERT INTO payments (order_id, razorpay_payment_id, payment_date, amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $order_id, $razorpay_payment_id, $payment_date, $amount);
        if ($stmt->execute()) {
            // Redirect to payment success page with order and payment ID
            header('Location: payment_success.php?order_id=' . $order_id . '&payment_id=' . $razorpay_payment_id);
            exit();
        } else {
            // Handle error - payment details insertion failed
            echo "Error: " . $stmt->error;
        }
    } else {
        // Handle error - order status update failed
        echo "Error: " . $stmt->error;
    }
} else {
    header('Location: index.php');
    exit();
}
