<?php include 'includes/header.php'; ?>
<?php
include 'server/connection.php';

// Add product to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
    $product_quantity = mysqli_real_escape_string($conn, $_POST['product_quantity']);

    $product_array = array(
        'product_id' => $product_id,
        'product_name' => $product_name,
        'product_price' => $product_price,
        'product_image' => $product_image,
        'product_quantity' => $product_quantity,
    );

    // Check if cart session variable exists
    if (isset($_SESSION['cart'])) {
        // Append product to existing cart array
        $_SESSION['cart'][] = $product_array;
    } else {
        // Start a new cart array
        $_SESSION['cart'] = array($product_array);
    }
}

// Remove product from cart-----------------need work
elseif (isset($_POST['remove_product'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Loop through the cart to find and remove the product
    foreach ($_SESSION['cart'] as $key => $product) {
        if ($product['product_id'] === $product_id) {
            unset($_SESSION['cart'][$key]);
            break; // Stop looping once the product is found and removed
        }
    }
}

// Update product quantity in cart-----------------need work
elseif (isset($_POST['edit_quantity'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $product_quantity = mysqli_real_escape_string($conn, $_POST['product_quantity']);

    // Loop through the cart to find the product and update its quantity
    foreach ($_SESSION['cart'] as $key => &$product) {
        if ($product['product_id'] === $product_id) {
            $_SESSION['cart'][$key]['product_quantity'] = $product_quantity;
            break; // Stop looping once the product is found and updated
        }
    }
}

// Function to calculate total cart amount
function calculateTotalCart()
{
    $total = 0;
    $quantity = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['product_quantity'] * $item['product_price'];
        $quantity += $item['product_quantity'];
    }
    $_SESSION['total'] = $total;
    $_SESSION['quantity'] = $quantity;
}

// Calculate total cart amount initially
calculateTotalCart();

// echo '<pre>';print_r($_SESSION);echo '</pre>';die();
?>



<!-- Cart Section -->
<section class="cart my-5 py-5">
    <div class="container-fluid mt-5">
        <h3 class="font-weight-bold">Your Cart</h3>
        <hr>
        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Sub-total</th>
            </tr>
            <?php foreach ($_SESSION['cart'] ?? [] as $key => $value) { ?>

                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/<?= $value['product_image']; ?>" alt="">
                            <div>
                                <p><?= $value['product_name']; ?></p>
                                <small><span>$</span><?= $value['product_price']; ?></small>
                                <br>
                                <form action="cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?= $value['product_id']; ?>">
                                    <input type="submit" name="remove_product" class="remove-btn" value="Remove">
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        <form action="cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $value['product_id']; ?>">
                            <input type="number" name="product_quantity" value="<?= $value['product_quantity']; ?>">
                            <input type="submit" name="edit_quantity" class="edit-btn" value="Edit">
                        </form>
                    </td>
                    <td>
                        <span>$</span>
                        <span class="product-price"><?= $value['product_quantity'] * $value['product_price']; ?></span>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <div class="cart-total">
            <table>
                <tr>
                    <td>Total</td>
                    <td>$<?= isset($_SESSION['total']) ? $_SESSION['total'] : '0'; ?></td>
                </tr>
            </table>
        </div>
        <div class="checkout-container pt-3">
            <form action="checkout.php" method="post">
                <input type="submit" class="checkout-btn" name="checkout" value="Checkout">
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>