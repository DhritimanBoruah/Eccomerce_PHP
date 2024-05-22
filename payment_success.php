<?php
include 'includes/header.php';
?>

<!-- Payment Success -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Payment Successful</h2>
        <hr class="mx-auto">
        <p>Thank you for your purchase! Your payment was successful.</p>
    </div>
    <div class="mx-auto container text-center mt-5">
        <!-- <p>Your order ID is: <?= htmlspecialchars($_GET['order_id']); ?></p>
        <p>Your payment ID is: <?= htmlspecialchars($_GET['payment_id']); ?></p> -->
        <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
</section>

<?php
include 'includes/footer.php';
?>