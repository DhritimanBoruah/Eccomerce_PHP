<?php
include "./includes/header.php";
include "../server/connection.php";

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    header('Location: orders.php');
    exit;
}

$order_id = $_GET['order_id'];

// Retrieve order details from the database
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id=?");
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returned any rows
if ($result->num_rows <= 0) {
    // Redirect if order not found
    header('Location: orders.php');
    exit;
}

// Fetch the order details
$order = $result->fetch_assoc();

// Check if form is submitted for updating order
if (isset($_POST['update_order'])) {
    // Retrieve updated order details from the form
    $order_status = $_POST['order_status'];

    // Prepare and execute the SQL update statement
    $stmt2 = $conn->prepare('UPDATE orders SET order_status=? WHERE order_id=?');
    $stmt2->bind_param("si", $order_status, $order_id);
    $update_result = $stmt2->execute();

    if ($update_result) {
        header('Location: index.php?order_updated=Order has been Updated!');
        exit;
    } else {
        header('Location: index.php?order_Failed=Error Occurred!');
        exit;
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
                            value="<?=$order['order_id']?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="order_price">Order Price</label>
                        <input type="text" class="form-control" id="order_price" name="order_price"
                            value="<?=isset($order['order_cost']) ? $order['order_cost'] : ''?>" required readonly>
                    </div>
                    <div class="form-group mt-2">
                        <label for="order_status">Order Status</label>
                        <select class="form-control" id="order_status" name="order_status" required>
                            <option value="">Select Order Status</option>
                            <option value="Not Paid" <?=($order['order_status'] === 'Not Paid') ? 'selected' : ''?>>
                                Not Paid</option>
                            <option value="Paid" <?=($order['order_status'] === 'Paid') ? 'selected' : ''?>>Paid
                            </option>
                            <option value="Delivered" <?=($order['order_status'] === 'Delivered') ? 'selected' : ''?>>
                                Delivered</option>
                            <option value="Shipped" <?=($order['order_status'] === 'Shipped') ? 'selected' : ''?>>
                                Shipped
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order_date">Order Date</label>
                        <input type="text" class="form-control" id="order_date" name="order_date"
                            value="<?=$order['order_date']?>" required readonly>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_order"
                        onclick="return confirm('Are you sure you want to update this order?')">Update</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include "./includes/footer.php";?>