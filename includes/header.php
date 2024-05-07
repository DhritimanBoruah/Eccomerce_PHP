<!-- <?php
session_start();

?> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
        <div class="container-fluid">
            <img class="logoo" src="assets/imgs/logoo.jpg" alt="" width="70" height="70" />
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <a href="cart.php">
                        <li class="nav-item"><i class="fas fa-shopping-cart">
                                <?php if (isset($_SESSION['quantity']) && $_SESSION['quantity'] != 0) {?>
                                <span class="cart_quantity"><?=$_SESSION['quantity'];?></span>
                                <?php }?>

                            </i></li>
                    </a>
                    <a href="register.php">
                        <li class="nav-item"><i class="fas fa-user"></i></li>
                    </a>
                </ul>
            </div>
    </nav>