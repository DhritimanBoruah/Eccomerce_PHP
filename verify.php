<?php
include 'server/connection.php'; // Include your database connection file

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Token exists, user is verified
        $user = $result->fetch_assoc();

        // Update user's status as verified 
        $stmt_update_status = $conn->prepare("UPDATE users SET is_verified = 1 WHERE token = ?");
        $stmt_update_status->bind_param('s', $token);
        $stmt_update_status->execute();
        $stmt_update_status->close();

        // Redirect the user to a success page
        echo ' <script>alert("Successfully verified.");</script>';
        header('location:login.php');
        exit;
    } else {
        // Token doesn't exist or is invalid
        echo ' <script>alert("failed to verify.");</script>';
        header('location:register.php');
        exit;
    }
} else {
    // Token is not provided in the URL
    echo ' <script>alert("failed to verify.");</script>';
    header('location:register.php');
    exit;
}
