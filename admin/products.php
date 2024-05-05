<?php

session_start(); // Start the session if not already started

// Check if admin is not logged in
// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: login.php"); // Redirect to the login page
//     exit(); // Stop further execution
// }

include "./includes/header.php";
include "../server/connection.php";

$page_title = 'Products';

include 'includes/navbar.php';
include 'includes/sidebar.php';

// echo $page_title;exit();

// Determine page no
if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    // If user already entered page then the user selected the page no
    $page_no = $_GET['page_no'];
} else {
    // If user just entered the page, then we get defaultly 1
    $page_no = 1;
}

// Return the number of products
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

// Products per page
$total_products_per_page = 5;
$offset = ($page_no - 1) * $total_products_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacent = "2";
$total_no_pages = ceil($total_records / $total_products_per_page);

// Get all products
$stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset,$total_products_per_page");
$stmt2->execute();
$products = $stmt2->get_result();
?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Products</h2>

                <?php if (isset($_GET['deleted_failure'])) {?>
                <p class="text-center" style="color:red;"><?=$_GET['deleted_failure'];?></p>
                <?php }?>

                <?php if (isset($_GET['deleted_successful'])) {?>
                <p class="text-center" style="color:green;"><?=$_GET['deleted_successful'];?></p>
                <?php }?>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <h4>Orders</h4>
                <div class="table-responsive">
                    <table class="table table-striped" id="productTable">
                        <thead>
                            <tr>
                                <th scope="col">Product Id</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Price</th>
                                <th scope="col">Product Offer</th>
                                <th scope="col">Product Category</th>
                                <th scope="col">Product Color</th>

                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($products as $product) {?>
                            <tr>
                                <td><?=$product['product_id'];?></td>
                                <td><img src="<?="../assets/imgs/" . $product['product_image'];?>" alt=""
                                        style="width:70px;height:70px;"></td>
                                <td><?=$product['product_name'];?></td>
                                <td><?="$" . $product['product_price'];?></td>
                                <td><?=$product['product_special_offer'] . "%";?></td>
                                <td><?=$product['product_category'];?></td>
                                <td><?=$product['product_color'];?></td>
                                <td><a href="edit_product.php?product_id=<?=$product['product_id'];?>"
                                        class="btn btn-primary">Edit</a></td>
                                <td><a href="delete_product.php" class="btn btn-danger">Delete</a></td>
                            </tr>


                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
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
        </div>
    </div>

    <?php include "./includes/footer.php";?>