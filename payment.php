<?php
include 'includes/header.php';
include 'server/connection.php';

$total = isset($_SESSION['total']) ? $_SESSION['total'] : 0; // Retrieve the total from session variable

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
        <?php if ($total != 0 || $order_status == "not paid") { ?>
            <p>Total Payment: $<?= $total != 0 ? $total : $order_total_price; ?></p>
            <form id="payment-form" action="payment.php" method="POST">
                <input type="hidden" name="amount" value="<?= $total != 0 ? $total * 100 : $order_total_price * 100 ?>">
                <input type="hidden" name="order_pay_btn" value="1">
                <button type="button" class="btn btn-primary" id="rzp-button">Pay now</button>
            </form>
        <?php } else { ?>
            <p>You don't have an order!</p>
        <?php } ?>
    </div>
</section>

<?php
include 'includes/footer.php';
?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "rzp_test_h2ndppkBYVhqvE", // Enter the Key ID generated from the Dashboard
        "amount": document.querySelector('input[name="amount"]').value, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "INR",
        "name": "Ecommerce", //your business name
        "description": "Test Transaction",
        "image": "./assets/imgs/logoo.jpg",
        "handler": function(response) {
            // Redirect or handle payment success
            console.log(response);
            // Redirect to success page or handle success response
            window.location.href = 'payment_success.php?payment_id=' + response.razorpay_payment_id;
        },
        "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information, especially their phone number
            "name": "Dhritiman", //your customer's name
            "email": "Dhritiman.kumar@example.com",
            "contact": "6001058634" //Provide the customer's phone number for better conversion rates 
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        }
    };

    document.getElementById('rzp-button').onclick = function(e) {
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    };
</script>