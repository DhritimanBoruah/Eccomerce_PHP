<?php

include 'connection.php';

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='watches' LIMIT 4");

$stmt->execute();

$watch_products = $stmt->get_result();
