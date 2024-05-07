<?php include 'includes/header.php';?>

<?php
include 'server/connection.php';

//use filter search
if (isset($_POST['search'])) {

    //determine page no
    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
        //if user already entered page then the user selected the page no
        $page_no = $_GET['page_no'];
    } else {
        //if user just entered the page,then we get defaultly 1
        $page_no = 1;
    }

    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    //return the number of product
    $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products WHERE product_category=? AND product_price<=?");
    $stmt1->bind_param('si', $category, $price);
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->store_result();
    $stmt1->fetch();

    //products per page
    $total_products_per_page = 8;
    $offset = ($page_no - 1) * $total_products_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacent = "2";
    $total_no_pages = ceil($total_records / $total_products_per_page);

    //get all products
    $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price<=? LIMIT $offset,$total_products_per_page");
    $stmt2->bind_param('si', $category, $price);
    $stmt2->execute();
    $products = $stmt2->get_result();

}
//return all products
else {

    //determine page no
    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
        //if user already entered page then the user selected the page no
        $page_no = $_GET['page_no'];
    } else {
        //if user just entered the page,then we get defaultly 1
        $page_no = 1;
    }

    //return the number of product
    $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->store_result();
    $stmt1->fetch();

    //products per page
    $total_products_per_page = 8;
    $offset = ($page_no - 1) * $total_products_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacent = "2";
    $total_no_pages = ceil($total_records / $total_products_per_page);

    //get all products
    $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset,$total_products_per_page");
    $stmt2->execute();
    $products = $stmt2->get_result();

}
?>



<style>
/* Sidebar and main content container */
#container {
    display: flex;
    align-items: stretch;
    /* Make both sections stretch to the same height */
}

/* Sidebar styles */
#search {
    width: 20%;
    background-color: white;
    padding-left: 20px;
    border-right: 1px solid #ccc;
    /* Add a solid border on the right side */
}


/* Main content styles */
#featured {
    width: 75%;
    background-color: white;
}

.product img {
    width: 100%;
    height: auto;
    box-sizing: border-box;
    object-fit: cover;
}

/* Pagination styles */
.pagination {
    float: right;
}

.pagination a {
    color: coral;
}

.pagination li:hover a {
    color: white;
    background-color: coral;
}
</style>

<!-- Container for sidebar and main content -->
<div id="container">
    <section id="search" class="my-5 py-5 ms-2">
        <div class="container mt-5 py-5">
            <h4>Search Products</h4>
        </div>
        <form action="shop.php" method="POST">
            <div class="row mx-auto container">
                <!-- Search form content -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p>Category</p>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" value="shoes" name="category" id="category_one"
                            <?php if (isset($category) && $category == 'shoes') {echo 'checked';}?>>
                        <label class="form-check-label" for="category_one">Shoes</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" value="coats" name="category" id="category_two"
                            <?php if (isset($category) && $category == 'coats') {echo 'checked';}?>>
                        <label class="form-check-label" for="category_two">Coats</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" value="watches" name="category" id="category_three"
                            <?php if (isset($category) && $category == 'watches') {echo 'checked';}?>>
                        <label class="form-check-label" for="category_three">Watches</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" value="other" name="category" id="category_four"
                            <?php if (isset($category) && $category == 'other') {echo 'checked';}?>>
                        <label class="form-check-label" for="category_four">Other</label>
                    </div>
                </div>

                <!-- <div class="col-lg-12 col-md-12 col-sm-12 my-5">
                    <p>Brand</p>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" value="nike" name="brand" id="brand_one">
                        <label class="form-check-label" for="flexRadioDefault">Nike</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" value="adidas" name="brand" id="brand_two">
                        <label class="form-check-label" for="flexRadioDefault">Adidas</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" value="rolex" name="brand" id="brand_three">
                        <label class="form-check-label" for="flexRadioDefault">Rolex</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" value="other" name="brand" id="brand_four">
                        <label class="form-check-label" for="flexRadioDefault">Other</label>
                    </div>
                </div> -->


                <div class="row mx-auto container my-3 py-3">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p>Price</p>
                        <input type="range" class="form-range w-70" name="price" value="<?php if (isset($price)) {
    echo $price;
} else {
    echo '100';
}?>" min="1" max="1000" id="customRange2">
                        <div class="w-30">
                            <span style="float:left">1</span>
                            <span style="float:right">1000</span>
                        </div>
                    </div>
                </div>


                <div class="form-group my-3 mx-3">
                    <input type="submit" name="search" value="Search" class="btn btn-primary">
                </div>
            </div>
        </form>
    </section>

    <!-- shop -->
    <section id="featured" class="my-5 py-5 ms-2">
        <div class="container text-center mt-5 py-5">
            <h3>Our Products</h3>
            <hr>
            <p>Here you can check our featured products</p>
        </div>
        <div class="row mx-auto container-fluid">
            <?php while ($row = $products->fetch_assoc()) {?>
            <div onclick="console.log('Clicked!'); window.location.href='single_product.php';"
                class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?=$row['product_image'];?>" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?=$row['product_name'];?></h5>
                <h4 class="p-price">$<?=$row['product_price'];?></h4>
                <a href="single_product.php?product_id=<?=$row['product_id'];?>"><button class="buy-btn">Buy
                        Now</button></a>
            </div>
            <?php }?>
        </div>

        <!-- Pagination -->
        <div class="container my-5">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($page_no <= 1) {echo 'disabled';}?>">
                        <a class="page-link"
                            href="<?php if ($page_no <= 1) {echo '#';} else {echo '?page_no=' . ($page_no - 1);}?>"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

                    <?php if ($page_no >= 3) {?>
                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                    <li class="page-item"><a class="page-link"
                            href="<?php echo "?page_no=" . $page_no; ?>"><?=$page_no;?></a></li>
                    <?php }?>

                    <li class="page-item">
                        <a class="page-link <?php if ($page_no >= $total_no_pages) {echo 'disabled';}?>"
                            href="<?php if ($page_no >= $total_no_pages) {echo '#';} else {echo '?page_no=' . ($page_no + 1);}?>"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
</div>

<?php include 'includes/footer.php';?>