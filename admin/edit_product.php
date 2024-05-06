<?php
include "./includes/header.php";
include "../server/connection.php";

// Initialize $products variable
$products = [];

// Check if product_id is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve product details from the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Fetch the product details
        $products = $result->fetch_assoc();
    } else {
        // Redirect if product not found
        header('Location: products.php');
        exit;
    }

    $stmt3 = $conn->prepare("SELECT * FROM `categories` WHERE `cat_status` = '1'");
    $stmt3->execute();
    $categories = $stmt3->get_result();

    $stmt4 = $conn->prepare("SELECT * FROM `colors` WHERE `col_status` = '1'");
    $stmt4->execute();
    $colors = $stmt4->get_result();

} elseif (isset($_POST['update_product'])) {
    $product_id = $conn->real_escape_string($_POST['product_id']);

    $product_name = $conn->real_escape_string($_POST['product_name']);
    $product_description = $conn->real_escape_string($_POST['product_description']);
    $product_price = $conn->real_escape_string($_POST['product_price']);
    $product_special_offer = $conn->real_escape_string($_POST['product_special_offer']);
    $product_category = $conn->real_escape_string($_POST['product_category']);
    $product_color = $conn->real_escape_string($_POST['product_color']);

    // Prepare and execute the SQL update statement
    $stmt2 = $conn->prepare('UPDATE products SET product_name=?, product_description=?, product_price=?, product_special_offer=?, product_category=?, product_color=? WHERE product_id=?');
    $stmt2->bind_param("ssdissi", $product_name, $product_description, $product_price, $product_special_offer, $product_category, $product_color, $product_id);
    $update_result = $stmt2->execute();

    if ($update_result) {
        // Show success message using JavaScript alert
        echo "<script>alert('Product updated successfully!');</script>";
        // Redirect to product.php after updating
        echo "<script>window.location.href = './products.php';</script>";
        exit;
    } else {
        // Show failure message using JavaScript alert
        echo "<script>alert('Failed to update product. Please try again.');</script>";
    }
} else {
    header('Location: product.php');
    exit;
}
?>

<style>
* {
    background-color: lightcyan;
}
</style>

<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-light p-4">
                <h2>Edit Product</h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-6">
                <form method="post" action="edit_product.php">
                    <input type="hidden" name="product_id"
                        value="<?=isset($products['product_id']) ? $products['product_id'] : ''?>">

                    <div class="form-group mt-2">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name"
                            value="<?=isset($products['product_name']) ? $products['product_name'] : ''?>" required>
                    </div>
                    <div class="form-group">
                        <label for="product_description">Product Description</label>
                        <input type="text" class="form-control" id="product_description" name="product_description"
                            value="<?=isset($products['product_description']) ? $products['product_description'] : ''?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="product_price">Product Price</label>
                        <input type="number" class="form-control" id="product_price" name="product_price"
                            value="<?=isset($products['product_price']) ? $products['product_price'] : ''?>" required>
                    </div>
                    <div class="form-group">
                        <label for="product_special_offer">Product Special Offer (%)</label>
                        <input type="number" class="form-control" id="product_special_offer"
                            name="product_special_offer"
                            value="<?=isset($products['product_special_offer']) ? $products['product_special_offer'] : ''?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="product_category">Product Category</label>
                        <select class="form-control" id="product_category" name="product_category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $row) {?>
                            <option value="<?=$row['cat_name']?>"
                                <?=isset($products['product_category']) && $products['product_category'] == $row['cat_name'] ? 'selected' : ''?>>
                                <?=ucwords($row['cat_name'])?>
                            </option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_color">Product Color</label>
                        <select class="form-control" id="product_color" name="product_color" required>
                            <option value="">Select Color</option>
                            <?php foreach ($colors as $row) {?>
                            <option value="<?=$row['col_name']?>"
                                <?=isset($products['product_color']) && $products['product_color'] == $row['col_name'] ? 'selected' : ''?>>
                                <?=ucwords($row['col_name'])?>
                            </option>
                            <?php }?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_product"
                        onclick="return confirm('Are you sure you want to update this product?')">Update</button>
                </form>
            </div>
        </div>
    </div>



    <!-- <script>
    $("#product_category").on('change', function() {
        var value = this.value;
        console.log(value)

        $.ajax({
            url: 'ajax/getSCats.php',
            type: 'post',
            data: {
                value: value
            },
            success: function(data) {
                console.log(data)

                var responseData = JSON.parse(data);

                // Select the dropdown element
                var selectDropdown = $('#product_sub_category');

                // Clear existing options
                selectDropdown.empty();


                // Loop through the data and create options
                $.each(responseData.details, function(index, item) {
                    // Create an option element
                    var option = $('<option></option>').attr('value', item.sb_cat_id).text(
                        item
                        .sb_cat_name);

                    // Append the option to the select dropdown
                    selectDropdown.append(option);
                });
            }
        })
    })
    </script> -->

    <?php include "./includes/footer.php";?>