<?php
include "./includes/header.php";
include "../server/connection.php";

// Check if product_id is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve product details from the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $products = $stmt->get_result();

    // Redirect if product not found
    if ($products->num_rows === 0) {
        header('Location: product.php');
        exit;
    }
} elseif (isset($_POST['update_product'])) {
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $product_description = $conn->real_escape_string($_POST['product_description']);
    $product_price = $conn->real_escape_string($_POST['product_price']);
    $product_special_offer = $conn->real_escape_string($_POST['product_special_offer']);
    $product_category = $conn->real_escape_string($_POST['product_category']);
    $product_color = $conn->real_escape_string($_POST['product_color']);

    // Prepare and execute the SQL update statement
    $stmt2 = $conn->prepare('UPDATE products SET product_name=?, product_description=?, product_price=?, product_special_offer=?, product_category=?, product_color=? WHERE product_id=?');
    $stmt2->bind_param("ssdiisi", $product_name, $product_description, $product_price, $product_special_offer, $product_category, $product_color, $product_id);
    $update_result = $stmt2->execute();

    if ($update_result) {
        // Show success message using JavaScript alert
        echo "<script>alert('Product updated successfully!');</script>";
        // Redirect to product.php after updating
        header('location:product.php');
    } else {
        // Show failure message using JavaScript alert
        echo "<script>alert('Failed to update product. Please try again.');</script>";
        header('location:edit_product.php');
    }
} else {
    header('Location: product.php');
    exit;
}
?>

<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Edit Product</h2>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">
            <form method="post" action="edit_product.php">
                <?php foreach ($products as $product) {?>
                <div class="form-group mt-2">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" placeholder="" id="product_name" name="product_name"
                        value="<?=$product['product_name']?>" required>
                </div>
                <div class="form-group">
                    <label for="product_description">Product Description</label>
                    <input type="text" class="form-control" id="product_description" name="product_description"
                        value="<?=$product['product_description'];?>" required>
                </div>
                <div class="form-group">
                    <label for="product_price">Product Price</label>
                    <input type="number" class="form-control" id="product_price" name="product_price"
                        value="<?=$product['product_price'];?>" required>
                </div>
                <div class="form-group">
                    <label for="product_special_offer">Product Special Offer (%)</label>
                    <input type="number" class="form-control" id="product_special_offer" name="product_special_offer"
                        value="<?=$product['product_special_offer'];?>" required>
                </div>
                <div class="form-group">
                    <label for="product_category">Product Category</label>
                    <select class="form-control" id="product_category" name="product_category" required>
                        <option value="">Select Category</option>
                        <option value="shoes">Shoes</option>
                        <option value="coat">Coats</option>
                        <option value="watch">Watches</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_color">Product Color</label>
                    <select class="form-control" id="product_color" name="product_color" required>
                        <option value="">Select Color</option>
                        <option value="red">Red</option>
                        <option value="blue">Blue</option>
                        <option value="yellow">Yellow</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <?php }?>
                <button type="submit" class="btn btn-primary" name="update_product">Update</button>
                <script>
                function confirmUpdate() {
                    if (confirm("Are you sure you want to update this product?")) {
                        // If user confirms, submit the form
                        document.getElementById('updateForm').submit();
                    }
                }
                </script>
            </form>
        </div>
    </div>
</div>

<?php include "./includes/footer.php";?>