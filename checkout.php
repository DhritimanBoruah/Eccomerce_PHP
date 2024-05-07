<?php
include 'includes/header.php';
?>

<?php

include 'server/connection.php';

$total = isset($_SESSION['total']) ? $_SESSION['total'] : 0; // Retrieve the total from session variable

if (!empty($_SESSION['cart']) && isset($_POST['checkout'])) {
    //let user in

}
//send user to home page
else {
    header('location:index.php');
}

?>









<!-- checkout -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">checkout</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <form action="server/place_order.php" method="post" id="checkout-form">
            <div class="form-group checkout-small-element">
                <label for="">Name</label>
                <input type="name" class="form-control" id="checkout-name" name="name" placeholder="Name" required>
            </div>
            <div class="form-group checkout-small-element">
                <label for="">Email</label>
                <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group checkout-small-element">
                <label for="">Phone</label>
                <input type="tel" class="form-control" id="checkout-Phone" name="phone" placeholder="Phone" required>
            </div>
            <div class="form-group checkout-small-element">
                <label for="">City</label>
                <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required>
            </div>
            <div class="form-group checkout-large-element">
                <label for="">Address</label>
                <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address"
                    required>
            </div>
            <div class="form-group checkout-btn-container">
                <p>Total: $<?=$total?></p> <!-- Display the total -->
                <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order">
            </div>
    </div>

</section>





<?php
include 'includes/footer.php';

?>