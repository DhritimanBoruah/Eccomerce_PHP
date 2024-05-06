<?php
session_start(); // Start the session

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    // If not logged in, redirect to login page
    header('location: login.php');
    exit;
}

include "../server/connection.php";

// Check if product_id is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Prepare and execute the SQL delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $delete_result = $stmt->execute();

    if ($delete_result) {
        // If deletion is successful, redirect back to products.php with success message
        header('location: ./products.php?deleted_successful=Product has been deleted successfully!');
        exit;
    } else {
        // If deletion fails, redirect back to products.php with failure message
        header('location: ./products.php?deleted_failure=Failed to delete product. Please try again!');
        exit;
    }
} else {
    // If product_id is not provided in the URL, redirect back to products.php
    header('location: ./products.php');
    exit;
}
