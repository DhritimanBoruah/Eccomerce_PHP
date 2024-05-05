<?php
include 'server/connection.php';
include 'includes/header.php';

session_start();

// Redirect if user is already logged in
if (isset($_SESSION['logged_in'])) {
    header('location:account.php');
    exit;
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password using SHA-1
    $hashed_password = sha1($password);

    $stmt = $conn->prepare('SELECT * FROM users WHERE user_email=? AND user_password=? LIMIT 1');
    $stmt->bind_param('ss', $email, $hashed_password);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['user_email'] = $user['user_email'];
            $_SESSION['logged_in'] = true;

            header('location:account.php?message=Logged in Successfully!');
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

<!-- Login Page -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Login</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <form action="login.php" method="post" id="login-form">
            <p style="color:red;"><?php if (isset($_GET['error'])) {echo $_GET['error'];}?></p>
            <p style="color:red;"><?php if (isset($_GET['message'])) {echo $_GET['message'];}?></p>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" id="login-email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <!-- Corrected the ID attribute to "login-password" -->
                <input type="password" class="form-control" id="login-password" name="password" placeholder="Password"
                    required>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" name="login" id="login-btn" value="Login">
            </div>
            <div class="form-group">
                <a href="register.php" id="login-url" class="btn">Don't have account? Register here</a>
            </div>
        </form>
    </div>
</section>


<?php
include 'includes/footer.php';
?>