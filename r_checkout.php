<?php
include 'includes/header.php';
include 'server/connection.php';

// Start the session
session_start();

// Retrieve the total from session variable
$total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Retrieve user information from the database based on the user ID
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT user_name, user_email, phone_number,  shipping_address, state FROM users WHERE user_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // If user data is fetched successfully, assign it to the respective form fields
    if ($user) {
        $name = $user['user_name'];
        $email = $user['user_email'];
        $phone = $user['phone_number'];
        $state = $user['state'];
        $address = $user['shipping_address'];
    }
}

if (!empty($_SESSION['cart']) && isset($_POST['checkout'])) {
    // User can proceed to checkout
} else {
    // Redirect user to home page if cart is empty or checkout not initiated
    header('Location: index.php');
    exit();
}

// Retrieve states
$stmt = $conn->prepare("SELECT id, name FROM states ORDER BY name");
$stmt->execute();
$result = $stmt->get_result();

?>

<!-- Checkout -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Checkout</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <form action="server/place_order.php" method="post" id="checkout-form">
            <div class="form-group checkout-small-element">
                <label for="checkout-name">Name</label>
                <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" value="<?php echo isset($name) ? $name : ''; ?>" required>
            </div>
            <div class="form-group checkout-small-element">
                <label for="checkout-email">Email</label>
                <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>" required>
            </div>
            <div class="form-group checkout-small-element">
                <label for="checkout-phone">Phone</label>
                <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" value="<?php echo isset($phone) ? $phone : ''; ?>" required maxlength="10">
            </div>
            <div class="form-group checkout-small-element">
                <label for="checkout-state">State</label>
                <select class="form-control" id="checkout-state" name="state" required>
                    <option value="">Select State</option>

                    <?php while ($row = $result->fetch_assoc()) { ?>

                        <option value="<?= $row['name']; ?>" <?php echo isset($state) && $state == $row['name'] ? 'selected' : ''; ?>><?= $row['name']; ?></option>

                    <?php }  ?>
                </select>
            </div>

            <div class="form-group checkout-large-element">
                <label for="checkout-address">Shipping Address</label>
                <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" value="<?php echo isset($address) ? $address : ''; ?>" required>
            </div>
            <div class="form-group checkout-btn-container">
                <p>Total: ₹<?= $total ?>/-</p> <!-- Display the total -->
                <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order">
            </div>
        </form>
    </div>
</section>

<?php
include 'includes/footer.php';
?>