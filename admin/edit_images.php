<?php
include "./includes/header.php";
include "../server/connection.php";

// Check if product_id and product_name are provided
if (!isset($_GET['product_id']) || !isset($_GET['product_name'])) {
    header('Location: products.php');
    exit;
}

$product_id = $_GET['product_id'];
$product_name = $_GET['product_name'];

// Retrieve product details from the database
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returned any rows
if ($result->num_rows <= 0) {
    // Redirect if product not found
    header('Location: products.php');
    exit;
}

// Fetch the product details
$product = $result->fetch_assoc();

?>

<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-light p-4">
                <h2>Edit Images</h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-2 justify-content-center">
            <div class="col-md-6">
                <form method="post" action="update_images.php" enctype="multipart/form-data" id="edit_image_form">
                    <input type="hidden" name="product_id" value="<?=$product['product_id']?>">
                    <input type="hidden" name="product_name" value="<?=$product['product_name']?>">

                    <div class="form-group">
                        <label for="image1">Image1</label>
                        <input type="file" class="form-control" id="image1" name="image1" required value="">
                    </div>

                    <div class="form-group">
                        <label for="image2">Image 2</label>
                        <input type="file" class="form-control" id="image2" name="image2" required value="">
                    </div>

                    <div class="form-group">
                        <label for="image3">Image 3</label>
                        <input type="file" class="form-control" id="image3" name="image3" required value="">
                    </div>

                    <div class="form-group">
                        <label for="image4">Image 4</label>
                        <input type="file" class="form-control" id="image4" name="image4" required value="">
                    </div>

                    <button type="submit" class="btn btn-primary" name="update_Image"
                        onclick="return confirm('Are you sure you want to update this product?')">Update</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include "./includes/footer.php";?>