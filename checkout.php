<?php


include 'includes/header.php';
include 'server/connection.php';

// Retrieve the total from session variable
$total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;

if (!empty($_SESSION['cart']) && isset($_POST['checkout'])) {
    // User can proceed to checkout
} else {
    // Redirect user to home page if cart is empty or checkout not initiated
    header('Location: index.php');
    exit();
}
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
                <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required>
            </div>
            <div class="form-group checkout-small-element">
                <label for="checkout-email">Email</label>
                <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group checkout-small-element">
                <label for="checkout-phone">Phone</label>
                <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required>
            </div>
            <div class="form-group checkout-small-element">
                <label for="checkout-city">City</label>
                <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required>
            </div>
            <div class="form-group checkout-large-element">
                <label for="checkout-address">Address</label>
                <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required>
            </div>
            <div class="form-group checkout-btn-container">
                <p>Total: $<?=$total?></p> <!-- Display the total -->
                <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order">
            </div>
        </form>
    </div>
</section>

<?php
include 'includes/footer.php';
?>
