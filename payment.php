<?php
include 'includes/header.php';
include 'server/connection.php';
session_start();

$total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

$stmt = $conn->prepare('SELECT * FROM orders WHERE order_id = ?');
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: index.php');
    exit();
}
?>

<!-- Payment -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
        <?php if ($total != 0) { ?>
            <p>Total Payment: $<?= $total ?></p>
            <form id="payment-form" action="store_payment.php" method="POST">
                <input type="hidden" name="amount" value="<?= $total * 100 ?>">
                <input type="hidden" name="order_id" value="<?= $order_id ?>">
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
        "amount": document.querySelector('input[name="amount"]').value, // Amount is in currency subunits
        "currency": "INR",
        "name": "Ecommerce",
        "description": "Test Transaction",
        "image": "./assets/imgs/logoo.jpg",
        "handler": function(response) {
            // Send the payment ID and order ID to the server
            var form = document.getElementById('payment-form');
            form.appendChild(document.createElement('input')).setAttribute('type', 'hidden');
            form.lastChild.setAttribute('name', 'razorpay_payment_id');
            form.lastChild.setAttribute('value', response.razorpay_payment_id);
            form.submit();
        },
        "prefill": {
            "name": "Dhritiman",
            "email": "Dhritiman@example.com",
            "contact": "9876543211"
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
