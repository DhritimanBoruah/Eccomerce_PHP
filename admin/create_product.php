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
                <h4>Orders</h4>
                <div>
                    <form method="post" action="add_product.php">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="product_category">Product Category</label>
                            <input type="text" class="form-control" id="product_category" name="product_category"
                                required value="">
                        </div>

                        <div class="form-group">
                            <label for="product_description">Product Description</label>
                            <textarea class="form-control" id="product_description" name="product_description"
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_image">Product Image</label>
                            <input type="file" class="form-control" id="product_image" name="product_image" required
                                value="">
                        </div>

                        <div class="form-group">
                            <label for="product_image2">Product Image 2</label>
                            <input type="file" class="form-control" id="product_image2" name="product_image2" required
                                value="">
                        </div>

                        <div class="form-group">
                            <label for="product_image3">Product Image 3</label>
                            <input type="file" class="form-control" id="product_image3" name="product_image3" required
                                value="">
                        </div>

                        <div class="form-group">
                            <label for="product_image4">Product Image 4</label>
                            <input type="file" class="form-control" id="product_image4" name="product_image4" required
                                value="">
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
                            <input type="text" class="form-control" id="product_color" name="product_color" required
                                value="">
                        </div>

                        <button type="submit" class="btn btn-primary">Add Product</button>
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