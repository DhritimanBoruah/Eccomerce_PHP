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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark" style="background-color: black;">
                                    <tr>
                                        <th scope="col">Product Image</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_details as $row) { ?>
                                        <tr>
                                            <td>
                                                <img src="../assets/imgs/<?= htmlspecialchars($row['product_image']); ?>" alt="item" width="100">
                                            </td>
                                            <td><?= $row['product_name']; ?></td>
                                            <td>₹<?= $row['product_price']; ?>/-</td>
                                            <td><?= $row['product_quantity']; ?></td>
                                            <td>₹<?= $row['product_quantity'] * $row['product_price']; ?>/-</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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