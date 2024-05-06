<?php

session_start(); // Start the session if not already started

// Check if admin is not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "./includes/header.php";
include "../server/connection.php";

$page_title = 'Account';

include 'includes/navbar.php';
include 'includes/sidebar.php';

?>

<style>
.bold-text {
    font-size: 20px;
    font-weight: bold;
}
</style>


<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Account</h2>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-8">
                <p class="bold-text">ID: <?=$_SESSION['admin_id'];?></p>
                <p class="bold-text">Name: <?=$_SESSION['admin_name'];?></p>
                <p class="bold-text">Email: <?=$_SESSION['admin_email'];?></p>
            </div>
        </div>
    </div>


</main>

<?php include "./includes/footer.php";?>