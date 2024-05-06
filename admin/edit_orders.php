<?php
include "./includes/header.php";
include "../server/connection.php";

// Initialize $orders variable
$order = [];

// Check if order_id is provided
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Retrieve order details from the database
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id=?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Fetch the order details
        $order = $result->fetch_assoc();
    } else {
        // Redirect if order not found
        header('Location: orders.php');
        exit;
    }
} else {
    // Redirect if order_id is not provided
    header('Location: orders.php');
    exit;
}

// Check if form is submitted for updating order
if (isset($_POST['update_order'])) {
    // Retrieve updated order details from the form
    $order_id = $conn->real_escape_string($_POST['order_id']);
    $order_status = $conn->real_escape_string($_POST['order_status']);

    // Prepare and execute the SQL update statement
    $stmt2 = $conn->prepare('UPDATE orders SET order_status=? WHERE order_id=?');
    $stmt2->bind_param("si", $order_status, $order_id);
    $update_result = $stmt2->execute();

    if ($update_result) {
        /* header('location:./order.php?order_updated=Order has been Updated!'); */
        // Show success message using JavaScript alert
        echo "<script>alert('Order updated successfully!');</script>";
        // Redirect to orders.php after updating
        echo "<script>window.location.href = './orders.php';</script>";
        exit;
    } else {
        header('location:./order.php?order_Failed=Error Occurred!');
        // Show failure message using JavaScript alert
        echo "<script>alert('Failed to update order. Please try again.');</script>";
    }
}
?>


<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Your HTML form for editing orders goes here -->
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-light p-4">
                <h2>Edit Order</h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-2 justify-content-center">
            <div class="col-md-6">
                <form method="post" action="edit_orders.php">

                    <input type="hidden" name="order_id" value="<?=$order['order_id']?>">


                    <div class="form-group">
                        <label for="user_id">Order ID</label>
                        <input type="text" class="form-control" id="user_id" name="user_id"
                            value="<?=$order['order_id']?>" required>
                    </div>

                    <div class="form-group">
                        <label for="order_price">Order Price</label>
                        <input type="text" class="form-control" id="order_price" name="order_price"
                            value="<?=isset($order['order_cost']) ? $order['order_cost'] : ''?>" required>
                    </div>



                    <div class="form-group mt-2">
                        <label for="order_status">Order Status</label>
                        <select class="form-control" id="order_status" name="order_status" required>
                            <option value="">Select Order Status</option>
                            <option value="Not Paid" <?=$order['order_status'] === 'Not Paid' ? 'selected' : ''?>>Not
                                Paid</option>
                            <option value="Paid" <?=$order['order_status'] === 'Paid' ? 'selected' : ''?>>Paid
                            </option>
                            <option value="Delivered" <?=$order['order_status'] === 'Delivered' ? 'selected' : ''?>>
                                Delivered</option>
                            <option value="Not Delivered" <?=$order['order_status'] === 'Shipped' ? 'selected' : ''?>>
                                Shipped
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="order_date">Order Date</label>
                        <input type="text" class="form-control" id="order_date" name="order_date"
                            value="<?=$order['order_date']?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_order"
                        onclick="return confirm('Are you sure you want to update this order?')">Update</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include "./includes/footer.php";?>