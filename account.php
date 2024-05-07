<?php
include 'includes/header.php';
include 'server/connection.php';

if (!isset($_SESSION['logged_in'])) {
    header('location:login.php');
    exit;
}

if (isset($_GET['logout'])) {
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    header('location:login.php');
    exit;
}

if (isset($_POST['change_password'])) {
    // Check if password and confirm password match
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    if ($password !== $cpassword) {
        header('location:account.php?error=Password does not match');
        exit;
    }

    // Hash the password using SHA-1
    $hashed_password = sha1($password);

    // Retrieve user email from session
    $email = $_SESSION['user_email'];

    // Update password in the database
    $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
    $stmt->bind_param('ss', $hashed_password, $email);
    if ($stmt->execute()) {
        header('location:account.php?message=Password has been updated!');
        exit;
    } else {
        header('location:account.php?error=Password could not be updated!');
        exit;
    }
}

//get orders
if (isset($_SESSION['logged_in'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=?");

    $stmt->bind_param('i', $user_id);

    $stmt->execute();

    $orders = $stmt->get_result();
}

?>


<!-- Login Page -->
<section class="my-5 py-5">
    <div class="row container mx-auto">
        <div class="text-left mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <h3 class="font-weight-bold">Account Info</h3>
            <hr class="mx-auto">
            <div class="account-info">
                <p>Name: <span><?php if (isset($_SESSION['user_name'])) {echo $_SESSION['user_name'];}?></span></p>
                <p>Email: <span><?php if (isset($_SESSION['user_email'])) {echo $_SESSION['user_email'];}?></span></p>
                <p><a href="#orders" id="order-btn" class="btn btn-primary">Your Orders</a></p>
                <p><a href="account.php?logout=1" name="logout" id="logout-btn" class="btn btn-danger">Logout</a></p>
            </div>
        </div>
        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <form action="account.php" id="account-form" method="post">
                <p style="color:red;"><?php if (isset($_GET['message'])) {echo $_GET['message'];}?></p>
                <p style="color:red;"><?php if (isset($_GET['error'])) {echo $_GET['error'];}?></p>
                <h3 class="font-weight-bold">Change Password</h3>
                <hr class="mx-auto">
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" id="account-password"
                        placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control" name="cpassword" id="account-password-confirm"
                        placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" name="change_password" id="change-pass-btn"
                        value="Change Password">
                </div>
            </form>

        </div>

    </div>

</section>

<!-- orders -->
<section class="orders my-5 py-3" id="orders">
    <div class="container mt-2">
        <h3 class="font-weight-bold text-center">Your Orders</h3>
        <hr class="mx-auto">
        <table class="mt-5 pt-5">
            <tr>
                <th>Order id</th>
                <th>Order Cost</th>
                <th>Order status</th>
                <th>Order date</th>
                <th>Order details</th>
            </tr>

            <?php while ($row = $orders->fetch_assoc()) {?>
            <tr>
                <td>
                    <span class="mt-3"><?=$row['order_id']?></span>

                </td>
                <td>
                    <span><?=$row['order_cost']?></span>
                </td>
                <td>
                    <span><?=$row['order_status']?></span>
                </td>
                <td>
                    <span><?=$row['order_date']?></span>
                </td>
                <td>
                    <form action="order_details.php" method="GET">
                        <input type="hidden" value="<?=$row['order_status'];?>" name="order_status">
                        <input type="hidden" name="order_id" value="<?=$row['order_id'];?>">
                        <input type="submit" class="btn" value="Details" name="order_details_btn"
                            style="width:auto;padding:2px;margin:10px;background-color:coral;color:white;">
                    </form>
                </td>
            </tr>

            <?php }?>

        </table>
    </div>
</section>






<?php
include 'includes/footer.php';
?>