<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="index.php" target="_blank">
            <img src="../../assets/imgs/logoo.jpg" alt="Logo" style="height: 100px;width:70px;">
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white <?=$page_title == 'Dashboard' ? 'active bg-gradient-primary' : '';?> "
                    href="index.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?=$page_title == 'Products' ? 'active bg-gradient-primary' : '';?>"
                    href="products.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">local_offer</i>
                    </div>
                    <span class="nav-link-text ms-1">Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?=$page_title == 'Orders' ? 'active bg-gradient-primary' : '';?>"
                    href="orders.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">shopping_cart</i>
                    </div>
                    <span class="nav-link-text ms-1">Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?=$page_title == 'Customers' ? 'active bg-gradient-primary' : '';?>"
                    href="customer.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">people</i>
                    </div>
                    <span class="nav-link-text ms-1">Customers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?=$page_title == 'Create Products' ? 'active bg-gradient-primary' : '';?>"
                    href="create_product.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">create</i>
                    </div>
                    <span class="nav-link-text ms-1">Create Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?=$page_title == 'Account' ? 'active bg-gradient-primary' : '';?>"
                    href="account.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">account_circle</i>
                    </div>
                    <span class="nav-link-text ms-1">Account</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link text-white" href="logout.php?logout=1" name="logout">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">exit_to_app</i>
                    </div>
                    <span class="nav-link-text ms-1">Logout</span>
                </a>
            </li> -->

        </ul>
    </div>

    <!-- <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn bg-gradient-primary mt-4 w-100"
                href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade
                to pro</a>
        </div>
    </div> -->



    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn bg-gradient-primary mt-4 w-100" href="logout.php?logout=1" name="logout" type="button" style="font-weight: bold;
        font-size: 16px;"><i class="material-icons opacity-10">exit_to_app</i>
                <span class="nav-link-text ms-1">Logout</span></a>
        </div>
    </div>
</aside>