<?php

session_start(); // Start the session if not already started

// Check if admin is not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "./includes/header.php";
include "../server/connection.php";

$page_title = 'Customers';

include 'includes/navbar.php';
include 'includes/sidebar.php';

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

//get all users
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->get_result();

?>


<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Customers</h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr style="background-color: coral; color:white;">
                                <th scope="col">User Id</th>
                                <th scope="col">User Name</th>
                                <th scope="col">User Email</th>
                            </tr>
                        </thead>

                        <?php foreach ($users as $user) {?>
                        <tr>
                            <td><?=$user['user_id'];?></td>
                            <td><?=$user['user_name'];?></td>
                            <td><?=$user['user_email'];?></td>
                        </tr>

                        <?php }?>
                        <tbody>

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