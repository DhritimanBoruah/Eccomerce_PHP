<?php

session_start(); // Start the session if not already started

// Check if admin is not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "./includes/header.php";
include "../server/connection.php";

$page_title = 'Create Products';

include 'includes/navbar.php';
include 'includes/sidebar.php';

if (isset($_POST['create_btn'])) {
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $product_description = $conn->real_escape_string($_POST['product_description']);
    $product_price = $conn->real_escape_string($_POST['product_price']);
    $product_special_offer = $conn->real_escape_string($_POST['product_special_offer']);
    $product_category = $conn->real_escape_string($_POST['product_category']);
    $product_color = $conn->real_escape_string($_POST['product_color']);

    $image1 = $_FILES['image1']['tmp_name'];
    $image2 = $_FILES['image2']['tmp_name'];
    $image3 = $_FILES['image3']['tmp_name'];
    $image4 = $_FILES['image4']['tmp_name'];

    $image_name1 = $product_name . "1.jpeg";
    $image_name2 = $product_name . "2.jpeg";
    $image_name3 = $product_name . "3.jpeg";
    $image_name4 = $product_name . "4.jpeg";

// Upload images
    move_uploaded_file($image1, "../assets/imgs/" . $image_name1);
    move_uploaded_file($image2, "../assets/imgs/" . $image_name2);
    move_uploaded_file($image3, "../assets/imgs/" . $image_name3);
    move_uploaded_file($image4, "../assets/imgs/" . $image_name4);

    $stmt = $conn->prepare("INSERT INTO products (product_name, product_category, product_description, product_image, product_image2, product_image3, product_image4, product_price, product_special_offer, product_color) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssss", $product_name, $product_category, $product_description,
        $image_name1, $image_name2, $image_name3, $image_name4, $product_price, $product_special_offer, $product_color);

    if ($stmt->execute()) {
        echo "<script>alert('Product Recorded successfully!');</script>";
        echo "<script>window.location.href = './products.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to record the product. Please try again.');</script>";
    }

}

?>


<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">




<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <h2>Create Products</h2>

                <?php if (isset($_GET['msg_failed'])) {?>
                <p class="text-center text-danger"><?=($_GET['msg_failed']);?></p>
                <?php }?>

                <?php if (isset($_GET['msg_suceesful'])) {?>
                <p class="text-center text-success"><?=$_GET['msg_suceesful'];?></p>
                <?php }?>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-8">
                <div>
                    <form method="post" action="create_product.php" id="create-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="product_category">Product Category</label>
                            <select class="form-control" id="product_category" name="product_category" required>
                                <option value="">Select Category</option>
                                <option value="Shoes">Shoes</option>
                                <option value="clothes">Chothes</option>
                                <option value="Watches">Watches</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="product_description">Product Description</label>
                            <textarea class="form-control" id="product_description" name="product_description"
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_price">Product Price</label>
                            <input type="text" class="form-control" id="product_price" name="product_price" required
                                value="">
                        </div>

                        <div class="form-group">
                            <label for="product_special_offer">Product Special Offer (%)</label>
                            <input type="text" class="form-control" id="product_special_offer"
                                name="product_special_offer" required value="">
                        </div>

                        <div class="form-group">
                            <label for="product_color">Product Color</label>
                            <select class="form-control" id="product_color" name="product_color" required>
                                <option value="">Select Color</option>
                                <option value="red">red</option>
                                <option value="blue">blue</option>
                                <option value="white">White</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image1">Product Image1</label>
                            <input type="file" class="form-control" id="image1" name="image1" required value="">
                        </div>

                        <div class="form-group">
                            <label for="image2">Product Image 2</label>
                            <input type="file" class="form-control" id="image2" name="image2" required value="">
                        </div>

                        <div class="form-group">
                            <label for="image3">Product Image 3</label>
                            <input type="file" class="form-control" id="image3" name="image3" required value="">
                        </div>

                        <div class="form-group">
                            <label for="image4">Product Image 4</label>
                            <input type="file" class="form-control" id="image4" name="image4" required value="">
                        </div>



                        <button type="submit" class="btn btn-primary" name="create_btn">Add Product</button>
                    </form>


                </div>
            </div>
        </div>

        <!-- Pagination -->
        <!-- <div class="row mt-5">
            <div class="col-md-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if ($page_no <= 1) {echo 'disabled';}?>">
                            <a class="page-link"
                                href="<?php if ($page_no <= 1) {echo '#';} else {echo '?page_no=' . ($page_no - 1);}?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $total_no_pages; $i++) {?>
                        <li class="page-item <?php if ($page_no == $i) {echo 'active';}?>">
                            <a class="page-link" href="?page_no=<?=$i;?>"><?=$i;?></a>
                        </li>
                        <?php }?>

                        <li class="page-item <?php if ($page_no >= $total_no_pages) {echo 'disabled';}?>">
                            <a class="page-link"
                                href="<?php if ($page_no >= $total_no_pages) {echo '#';} else {echo '?page_no=' . ($page_no + 1);}?>"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div> -->
    </div>

    <?php include "./includes/footer.php";?>