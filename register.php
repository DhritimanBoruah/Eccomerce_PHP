<?php
include 'server/connection.php';
include 'includes/header.php';

// Redirect if user is already logged in
if (isset($_SESSION['logged_in'])) {
    header('location:account.php');
    exit;
}

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    if ($password !== $cpassword) {
        header('location:register.php?error=password does not match');
        exit;
    } elseif (strlen($password) < 6) {
        header('location:register.php?error=password length must be more than 6 characters!');
        exit;
    }

    // Hash the password using SHA-1
    $hashed_password = sha1($password);

    // Check if user with this email already exists
    $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();

    if ($num_rows != 0) {
        header('location:register.php?error=User with this email already exists.');
        exit;
    }

    // Create a new user
    $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password) VALUES (?,?,?)");
    $stmt->bind_param('sss', $name, $email, $hashed_password);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['logged_in'] = true;
        header('location:account.php?register=You Registered Successfully!');
        exit;
    } else {
        header('location:register.php?error=Account could not be created at this moment.');
        exit;
    }
}
?>

<!-- Register Page -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Register</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <form action="register.php" id="register-form" method="post">
            <p style="color:red;"><?php if (isset($_GET['error'])) {echo $_GET['error'];}?></p>
            <p style="color:red;"><?php if (isset($_GET['register'])) {echo $_GET['register'];}?></p>
            <div class="form-group">
                <label for="register-name">Name</label>
                <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label for="register-email">Email</label>
                <input type="email" class="form-control" id="register-email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="register-password">Password</label>
                <input type="password" class="form-control" id="register-password" name="password"
                    placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="register-cpassword">Confirm Password</label>
                <input type="password" class="form-control" id="register-cpassword" name="cpassword"
                    placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control" id="register-btn" name="register" value="Register">
            </div>
            <div class="form-group">
                <a href="login.php" id="register-url" class="btn">Have an account? Login here</a>
            </div>
        </form>

    </div>
</section>

<?php
include 'includes/footer.php'
?>