<?php
include 'server/connection.php';
session_start();
$total = isset($_SESSION['total']) ? $_SESSION['total'] : 0; // Retrieve the total from session variable

include 'includes/header.php';

// Check if the payment button is clicked and fetch order details if available
if (isset($_POST['order_pay_btn'])) {
    // Fetch order details from the database (You need to implement this part)
    // For now, let's assume $row is fetched from the database
    $order_status = isset($row['order_status']) ? $row['order_status'] : '';
    $order_total_price = isset($row['order_total_price']) ? $row['order_total_price'] : '';
}
?>

<!-- payment -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
        <?php if ($total != 0) {?>
        <p>Total Payment: $<?=$total;?></p>
        <form action="payment.php" method="POST">
            <input type="submit" class="btn btn-primary" name="order_pay_btn" value="Pay now">
        </form>
        <?php } else if ($order_status == "not paid") {?>
        <p>Total Payment: $<?=$order_total_price;?></p>
        <form action="payment.php" method="POST">
            <input type="submit" class="btn btn-primary" name="order_pay_btn" value="Pay now">
        </form>
        <?php } else {?>
        <p>You don't have an order!</p>
        <?php }?>
    </div>
</section>

<?php
include 'includes/footer.php';
?>



<!-- -----------------need to handle this....from order deTila to this page and checkout to this page------------ -->