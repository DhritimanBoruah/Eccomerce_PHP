<?php
// session_start(); // Ensure session is started

include 'includes/header.php';
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
        // Check if product is already in the cart and update quantity
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] === $product_id) {
                $item['product_quantity'] += $product_quantity;
                $found = true;
                break;
            }
        }
        if (!$found) {
            // Append product to existing cart array
            $_SESSION['cart'][] = $product_array;
        }
    } else {
        // Start a new cart array
        $_SESSION['cart'] = array($product_array);
    }
}

// Remove product from cart
elseif (isset($_POST['remove_product'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Loop through the cart to find and remove the product
    foreach ($_SESSION['cart'] as $key => $product) {
        if ($product['product_id'] === $product_id) {
            unset($_SESSION['cart'][$key]);
            // Reindex the array to prevent gaps
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            break; // Stop looping once the product is found and removed
        }
    }
}

// Update product quantity in cart
elseif (isset($_POST['edit_quantity'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $product_quantity = mysqli_real_escape_string($conn, $_POST['product_quantity']);

    // Ensure quantity is a positive integer
    if (filter_var($product_quantity, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
        // Loop through the cart to find the product and update its quantity
        foreach ($_SESSION['cart'] as $key => &$product) {
            if ($product['product_id'] === $product_id) {
                $product['product_quantity'] = $product_quantity;
                break; // Stop looping once the product is found and updated
            }
        }
    }
}

// Function to calculate total cart amount
function calculateTotalCart()
{
    $total = 0;
    $quantity = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['product_quantity'] * $item['product_price'];
            $quantity += $item['product_quantity'];
        }
    }
    $_SESSION['total'] = $total;
    $_SESSION['quantity'] = $quantity;
}

// Calculate total cart amount initially
calculateTotalCart();

?>


<style>
    .btn-get-started {
        background: #ebe703;
        border: 2px solid #a85303;
        color: #fff;
    }

    .cart .table {
        margin-bottom: 30px;
        border-bottom: 1px solid #fff;
    }

    .cart .table thead tr th {
        font-size: 16px;
        border-top: 0;
        border-bottom: 0;
    }

    .cart .table tbody tr td {
        vertical-align: middle;
    }

    .cart .table tbody tr td .main .d-flex img {
        border: 2px solid #000;
        border-radius: 3px;
    }

    .cart .table tbody tr td .main .des p {
        margin-bottom: 0;
    }

    /* checkout */

    .checkout ul {
        border: 2px solid #ebebeb;
        background: #f3f3f3;
        padding: 16px 25px 20px;
    }

    .checkout ul li {
        font-size: 16px;
        text-transform: uppercase;
        overflow: hidden;
    }

    .checkout ul li.subtotal {
        /*  text-transform: capitalize; */
        border-bottom: 1px solid #fff;
        padding-bottom: 14px;
    }

    .checkout ul li.cart-total {
        padding-top: 10px;
    }

    .checkout ul li span {
        float: right;
    }

    .checkout-container .checkout-btn {
        font-size: 15px;
        color: #fff;
        background: #252525;
        padding: 15px 25px;
        display: block;
        text-align: center;
    }

    .checkout-btn:hover {
        background-color: coral;
    }
</style>



<!-- Cart Section -->
<section class="cart my-5 py-5">
    <div class="container-fluid mt-5">
        <h3 class="font-weight-bold">Your Cart</h3>
        <hr>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-white">Product</th>
                        <th scope="col" class="text-white">Price</th>
                        <th scope="col" class="text-white">Quantity</th>
                        <th scope="col" class="text-white">Total</th>
                        <th scope="col" class="text-white d-flex justify-content-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] ?? [] as $key => $value) { ?>
                        <tr>
                            <td>
                                <div class="main">
                                    <div class="d-flex">
                                        <img src="assets/imgs/<?= htmlspecialchars($value['product_image']); ?>" alt="" width="155" height="110">
                                    </div>
                                    <div class="des" style="font-weight: bold;">
                                        <p><?= htmlspecialchars($value['product_name']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="product-price"><?= htmlspecialchars($value['product_price']); ?>/-</span>
                            </td>
                            <td>
                                <form action="cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($value['product_id']); ?>">
                                    <input class="input-number" type="number" name="product_quantity" value="<?= htmlspecialchars($value['product_quantity']); ?>" min="1">
                                    <input type="submit" name="edit_quantity" class="edit-btn" value="Edit">
                                </form>
                            </td>
                            <td>
                                <span class="product-price"><?= htmlspecialchars($value['product_quantity'] * $value['product_price']); ?>/-</span>
                            </td>
                            <td>
                                <form action="cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($value['product_id']); ?>">
                                    <input type="submit" name="remove_product" class=" remove-btn" value="Remove">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-4 offset-lg-4">
            <div class="checkout">
                <ul>
                    <li class="subtotal" style="font-weight: bold;">Subtotal
                        <span><?= isset($_SESSION['total']) ? htmlspecialchars($_SESSION['total']) : '0'; ?>/-</span>
                    </li>
                    <li class="subtotal" style="font-weight: bold;">Total
                        <span><?= isset($_SESSION['total']) ? htmlspecialchars($_SESSION['total']) : '0'; ?>/-</span>
                    </li>

                </ul>

                <div class="checkout-container">
                   <!--  If $_SESSION['user_id'] is set (meaning the user is logged in), the form action is set to r_checkout.php. Otherwise, it's set to checkout.php. -->
                    <form method="post" <?php echo isset($_SESSION['user_id']) ? 'action="r_checkout.php"' : 'action="checkout.php"'; ?>>
                        <input type="submit" class="checkout-btn" name="checkout" value="Checkout">
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIyUqM4j4WpzsJrn57uCBiQmiggI6g00gQ2vZ6jIW" crossorigin="anonymous"></script>

<?php include 'includes/footer.php'; ?>