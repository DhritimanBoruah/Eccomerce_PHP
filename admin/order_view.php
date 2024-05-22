<?php
include "./includes/header.php";
include "../server/connection.php";

$order_details = []; // Initialize the variable to avoid undefined variable warnings

if (isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order_details_result = $stmt->get_result();

    // Fetch order details
    while ($row = $order_details_result->fetch_assoc()) {
        $order_details[] = $row;
    }

    // If no order details found, you might want to redirect or display a message
    if (empty($order_details)) {
        echo "<p>No order details found.</p>";
    }
}

?>

<style>
    .item {
        background-color: beige;
    }
</style>

<!-- orders -->
<section class="orders my-5 py-5" id="orders">
    <div class="container mt-2">
        <div class="row" style="margin-top: 50px;">
            <div class="col-md-12">
                <h3 class="font-weight-bold text-center">Order Details</h3>
                <div class="text-center mt-4">
                    <a href="orders.php" class="btn btn-primary">Back to Orders</a>
                </div>
                <hr class="mx-auto">
                <?php if (!empty($order_details)) { ?>
                    <div class="item">
                        <div class="container">
                            <div class="row">
                                <?php $count = 0; ?>
                                <?php foreach ($order_details as $row) { ?>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card mb-4">
                                            <img src="../assets/imgs/<?= $row['product_image']; ?>" class="card-img-top" alt="item" />
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $row['product_name']; ?></h5>
                                                <p class="card-text">Price: <em><?= $row['product_price']; ?>/-</em></p>
                                                <p class="card-text">Quantity: <em><?= $row['product_quantity']; ?>/-</em></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $count++; ?>
                                    <?php if ($count % 4 == 0) { ?>
                                        <!-- Start a new row after every fourth product -->
                            </div>
                            <div class="row">
                            <?php } ?>
                        <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</section>


<?php
include 'includes/footer.php';
?>