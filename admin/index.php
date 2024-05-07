<?php

session_start(); // Start the session if not already started

// Check if admin is not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "./includes/header.php";
include "../server/connection.php";

$page_title = 'Dashboard';

include 'includes/navbar.php';
include 'includes/sidebar.php';

// Query to get the total number of orders
$stmt = $conn->prepare("SELECT COUNT(*) AS total_orders FROM orders");
$stmt->execute();
$result = $stmt->get_result();
$totalOrders = $result->fetch_assoc()['total_orders'];

// Query to get the total number of products
$stmt = $conn->prepare("SELECT COUNT(*) AS total_products FROM products");
$stmt->execute();
$products = $stmt->get_result();
$totalProducts = $products->fetch_assoc()['total_products'];

// Query to get the total number of customers
$stmt = $conn->prepare("SELECT COUNT(*) AS total_customers FROM users");
$stmt->execute();
$customers = $stmt->get_result();
$totalCustomers = $customers->fetch_assoc()['total_customers'];

?>




<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Dashboard</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-4">
                <div class="card bg-primary text-white mb-4" style="height: 200px;">
                    <div class="card-body">
                        <h2 class="card-title">Orders</h2>
                        <p class="card-text" style="color: white;">Total number of orders:
                            <span style="font-size: 40px;"><?=$totalOrders?></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white mb-4" style="height: 200px;">
                    <div class="card-body">
                        <h2 class="card-title">Customers</h2>
                        <p class="card-text" style="color: white;">Total number of customers:
                            <span style="font-size: 40px;"><?=$totalCustomers?></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark mb-4" style="height: 200px;">
                    <div class="card-body">
                        <h2 class="card-title">Products</h2>
                        <p class="card-text" style="color: white;">Total number of products:
                            <span style="font-size: 40px;"><?=$totalProducts?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-8">
                <canvas id="barGraph" width="400" height="150px"></canvas>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
    // Sample data for bar graph (replace with actual data fetched from your database)
    var months = ['January', 'February', 'March', 'April', 'May', 'June'];
    var ordersData = [100, 120, 90, 110, 80, 100];

    var ctx = document.getElementById('barGraph').getContext('2d');
    var barGraph = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Orders',
                data: ordersData,
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>



    <?php
include "./includes/footer.php";?>