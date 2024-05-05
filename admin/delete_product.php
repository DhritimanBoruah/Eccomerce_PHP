<?php
session_start(); // Start the session

// Check if admin is not logged in
// if (!isset($_SESSION['admin_logged_in'])) {
//     header('location: login.php');
//     exit;
// }

include "../server/connection.php";

// Check if product_id is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Prepare and execute the SQL delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $delete_result = $stmt->execute();

    if ($delete_result) {
        // Redirect back to products.php after successful deletion
        header('location: products.php?deleted_successful=Product has been deleted successfully!');
        exit;
    } else {
        // Handle deletion failure
        header('location: products.php?deleted_failure=Failed to delete product. Please try again.!');
    }
} /* else {
// Redirect back to products.php if product_id is not provided
header('Location: products.php');
exit;
} */
