<?php
include 'includes/header.php';
include 'server/connection.php';

if (isset($_GET['order_details_btn']) && isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);
    $order_status = mysqli_real_escape_string($conn, $_GET['order_status']);

    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order_details_result = $stmt->get_result();

    // Initialize the variable to store order details
    $order_details = [];

    // Fetch order details
    while ($row = $order_details_result->fetch_assoc()) {
        $order_details[] = $row;
    }

    // Calculate total order price
    $total_order_price = calculateTotalOrderPrice($order_details);
}

// Function to calculate total order amount
function calculateTotalOrderPrice($order_details)
{
    $total = 0;
    foreach ($order_details as $row) {
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];

        $total += ($product_price * $product_quantity);
    }
    return $total;
}

?>

<!-- orders -->
<section class="orders my-5 py-5" id="orders">
    <div class="container mt-2">
        <div class="row" style="margin-top: 50px;">
            <h3 class="font-weight-bold text-center">Orders</h3>
            <hr class="mx-auto">
            <table class="mt-5 pt-5 mx-auto">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>

                <?php foreach ($order_details as $row) {?>
                <tr>
                    <td>
                        <div class="product_info">
                            <img src="assets/imgs/<?=$row['product_image'];?>" alt="">
                            <div>
                                <p class="mt-3"><?=$row['product_name'];?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span>$<?=$row['product_price'];?></span>
                    </td>
                    <td>
                        <span><?=$row['product_quantity'];?></span>
                    </td>

                </tr>

                <?php }?>

            </table>

            <?php if ($order_status == "not paid") {?>
            <form action="payment.php" method="POST" style="float: right;">
                <input type="hidden" value=<?=$total_order_price;?> name="total_order_price">
                <input type="hidden" value="<?=$order_status;?>" name="order_status">
                <input type="submit" name="order_pay_btn" class="btn btn-primary" value="Pay Now">
            </form>
            <?php }?>


        </div>
    </div>

</section>

<?php
include 'includes/footer.php';
?>