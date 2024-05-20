<?php include 'server/connection.php';
include 'includes/header.php';
?>




<!-- home -->
<section id="home">
    <div class="container">
        <h5>NEW ARRIVALS</h5>
        <h1><span>Best Prices </span>This Season</h1>
        <p>E-shop offers the best products for the most affordable prices</p>
        <button>Shop Now</button>
    </div>
</section>

<!-- brand -->
<section id="brand" class="text-center mt-5 py-5">
    <div class="container">
        <h3>Brands</h3>
        <hr>
        <p>Here you can check our brands</p>
        <br>
    </div>

    <div class="row">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/nike.jpg" alt="">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/puma.webp" alt="">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/mothercare.png" alt="">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/adidas.png" alt="">
    </div>
</section>

<!-- NEW -->
<section id="new" class=" text-center mt-5 py-5">
    <div class="container">
        <h3>New</h3>
        <hr>
        <p>check here</p>
        <br>
    </div>

    <div class="row p-0 m-0">
        <!-- one -->
        <div class="one col-lg-4 col-md-12 col-sm-12 p-0 ">
            <img class="img-fluid" src="assets/imgs/1.webp" alt="">
            <div class="details">
                <h2>Extremely Awsome Shoes</h2>
                <a href="shop.php"><button class="text-uppercase">Shop Now</button></a>
            </div>
        </div>
        <!-- two -->
        <div class="one col-lg-4 col-md-12 col-sm-12 p-0 ">
            <img class="img-fluid" src="assets/imgs/2.avif" alt="">
            <div class="details">
                <h2>Awsome Jackets</h2>
                <a href="shop.php"><button class="text-uppercase">Shop Now</button></a>
            </div>
        </div>
        <!-- three -->
        <div class="one col-lg-4 col-md-12 col-sm-12 p-0 ">
            <img class="img-fluid" src="assets/imgs/3.webp" alt="">
            <div class="details">
                <h2>50% OFF watches</h2>
                <a href="shop.php"><button class="text-uppercase">Shop Now</button></a>
            </div>
        </div>
    </div>
</section>




<!-- feature -->
<section id="featured" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Our Featured</h3>
        <hr>
        <p>Here you can check our featured products</p>
    </div>
    <div class="row mx-auto container-fluid">

        <!-- php codes -->
        <?php include 'server/get_featured_products.php'; ?>

        <?php while ($row = $featured_products->fetch_assoc()) { ?>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?= $row['product_image']; ?>" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?= $row['product_name']; ?></h5>
                <h4 class="p-price"><?= $row['product_price']; ?>/-</h4>
                <a href="single_product.php?product_id=<?= $row['product_id']; ?>"><button class="buy-btn">Buy
                        Now</button></a>
            </div>

        <?php } ?>

    </div>
</section>



<!-- Banner -->
<section id="banner" class="my-5 pb-5">
    <div class="container">
        <h4>MID SEASON'S SALE</h4>
        <h1>Autumn Collection <br> UP to 30% OFF</h1>
        <button class="text-uppercase">Shop Now</button>

    </div>

</section>


<!-- clothes -->
<section id="clothes" class="my-5">
    <div class="container text-center mt-5 py-5">
        <h3>Dresses and Coats</h3>
        <hr>
        <p>Here you can check our amazing clothes</p>
    </div>
    <div class="row mx-auto container-fluid">

        <?php include 'server/get_coats.php' ?>

        <?php while ($row = $coat_products->fetch_assoc()) { ?>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?= $row['product_image']; ?>" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?= $row['product_name']; ?></h5>
                <h4 class="p-price"><?= $row['product_price']; ?>/-</h4>
                <a href="single_product.php?product_id=<?= $row['product_id']; ?>"><button class="buy-btn">Buy
                        Now</button></a>
            </div>

        <?php } ?>

    </div>
</section>

<!-- Shoes -->
<section id="featured" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Shoes</h3>
        <hr>
        <p>Here you can check our amazing Shoes</p>
    </div>
    <div class="row mx-auto container-fluid">

        <?php include 'server/get_shoes.php' ?>

        <?php while ($row = $shoes_products->fetch_assoc()) { ?>


            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?= $row['product_image']; ?>" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?= $row['product_name']; ?></h5>
                <h4 class="p-price"><?= $row['product_price']; ?>/-</h4>
                <a href="single_product.php?product_id=<?= $row['product_id']; ?>"><button class="buy-btn">Buy
                        Now</button></a>
            </div>



        <?php } ?>

    </div>


</section>

<!-- watches -->
<section id="featured" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>watches</h3>
        <hr>
        <p>Here you can check our amazing watches</p>
    </div>
    <div class="row mx-auto container-fluid">
        <?php include 'server/get_watches.php' ?>

        <?php while ($row = $watch_products->fetch_assoc()) { ?>


            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?= $row['product_image']; ?>" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?= $row['product_name']; ?></h5>
                <h4 class="p-price"><?= $row['product_price']; ?>/-</h4>
                <a href="single_product.php?product_id=<?= $row['product_id']; ?>"><button class="buy-btn">Buy
                        Now</button></a>
            </div>



        <?php } ?>
    </div>
</section>

<?php
include 'includes/footer.php';

?>