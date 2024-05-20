<?php
include 'server/connection.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    $single_product = $stmt->get_result();
    $product = $single_product->fetch_assoc();

    // Fetch related products
    $category = $product['product_category'];
    $related_stmt = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_id != ? LIMIT 4");
    $related_stmt->bind_param("si", $category, $product_id);
    $related_stmt->execute();
    $related_products = $related_stmt->get_result();

} else {
    header('Location: index.php');
}

include 'includes/header.php';
?>

<!-- page section -->
<section class="container-fluid single-product my-5 pt-5">
    <div class="row mt-5">
        <div class="col-lg-5 col-md-6 col-sm-12">
            <img class="img-fluid w-100 pb-1" src="assets/imgs/<?=$product['product_image'];?>" alt="" id="main-image">

            <!-- variety of this product  -->
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="assets/imgs/<?=$product['product_image'];?>" width="150" class="small-img" alt="">
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?=$product['product_image2'];?>" width="150" class="small-img" alt="">
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?=$product['product_image3'];?>" width="150" class="small-img" alt="">
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?=$product['product_image4'];?>" width="150" class="small-img" alt="">
                </div>
            </div>
        </div>

        <!-- details section -->
        <div class="col-lg-6 col-md-12 col-sm-12">
            <h6 style="color: coral;"><?=$product['product_category'];?></h6>
            <h3 class="py-4"><?=$product['product_name'];?></h3>
            <h2><?=$product['product_price'];?>/-</h2>

            <form action="cart.php" method="post">
                <input type="hidden" name="product_id" value="<?=$product['product_id'];?>">
                <input type="hidden" name="product_image" value="<?=$product['product_image'];?>">
                <input type="hidden" name="product_name" value="<?=$product['product_name'];?>">
                <input type="hidden" name="product_price" value="<?=$product['product_price'];?>">
                <input type="number" name="product_quantity" value="1">
                <button class="buy-btn" type="submit" name="add_to_cart">ADD To Cart</button>
            </form>

            <h4 class="mt-5 mb-5">Product Details</h4>
            <span><?=$product['product_description'];?></span>
        </div>
    </div>
</section>

<!-- related product section -->
<section id="related-product" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Related Products</h3>
        <hr>
    </div>
    <div class="row mx-auto container-fluid">
        <?php while ($related = $related_products->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?=$related['product_image'];?>" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?=$related['product_name'];?></h5>
                <h4 class="p-price"><?=$related['product_price'];?>/-</h4>
                <a href="single_product.php?product_id=<?=$related['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
            </div>
        <?php } ?>
    </div>
</section>

<script>
/* change images */
var mainImg = document.getElementById("main-image");
var smallImg = document.getElementsByClassName("small-img");

for (let i = 0; i < 4; i++) {
    smallImg[i].onclick = function() {
        mainImg.src = smallImg[i].src;
    }
}
</script>

<?php
include 'includes/footer.php';
?>
