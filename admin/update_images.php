<?php

include "../server/connection.php";

if (isset($_POST['update_Image'])) {
    // Get product details
    $product_name = $conn->real_escape_string($_POST['product_name']);

    // Get uploaded images
    $image1 = $_FILES['image1']['tmp_name'];
    $image2 = $_FILES['image2']['tmp_name'];
    $image3 = $_FILES['image3']['tmp_name'];
    $image4 = $_FILES['image4']['tmp_name'];

    // Define image names
    $image_name1 = $product_name . "1.jpeg";
    $image_name2 = $product_name . "2.jpeg";
    $image_name3 = $product_name . "3.jpeg";
    $image_name4 = $product_name . "4.jpeg";

    // Upload images
    move_uploaded_file($image1, "../assets/imgs/" . $image_name1);
    move_uploaded_file($image2, "../assets/imgs/" . $image_name2);
    move_uploaded_file($image3, "../assets/imgs/" . $image_name3);
    move_uploaded_file($image4, "../assets/imgs/" . $image_name4);

    // Prepare SQL statement to update product images
    $stmt = $conn->prepare("UPDATE products SET product_image=?, product_image2=?, product_image3=?, product_image4=? WHERE product_name=?");

    // Bind parameters and execute statement
    $stmt->bind_param("sssss", $image_name1, $image_name2, $image_name3, $image_name4, $product_name);

    if ($stmt->execute()) {
        echo "<script>alert('Product images updated successfully!');</script>";
        echo "<script>window.location.href = './products.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to update product images. Please try again.');</script>";
    }
}
