<?php

include '../server/connection.php';

session_start();

// Redirect if user is already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header('location:index.php');
    exit;
}

if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password using SHA-1
    $hashed_password = sha1($password);

    $stmt = $conn->prepare('SELECT * FROM admins WHERE admin_email=? AND admin_password=? LIMIT 1');
    $stmt->bind_param('ss', $email, $hashed_password);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['admin_name'];
            $_SESSION['admin_email'] = $admin['admin_email'];
            $_SESSION['admin_logged_in'] = true;

            header('location:index.php?message=Logged in Successfully!');
            exit;
        } else {
            header('location:login.php?error=Could not verify your account!');
            exit;
        }
    } else {
        header('location:login.php?error=Something went wrong!');
        exit;
    }

}

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
    body {
        background-color: #f8f9fa;
    }

    .login-container {
        max-width: 400px;
        margin: auto;
        margin-top: 100px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="login-container">
                    <h2 class="text-center mb-4">Admin Login</h2>
                    <form action="login.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username">Email</label>
                            <input type="text" class="form-control" name="email" id="username"
                                placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter password">
                        </div>
                        <button type="submit" name="login_btn" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
