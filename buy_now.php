<?php
include "admin/connection.php";
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['customer_id'];

$product_id = intval($_POST['product_id'] ?? 0);
$size = $_POST['size'] ?? '';

if ($product_id <= 0 || empty($size)) {
    die("Invalid request");
}

$productQuery = mysqli_query($con, "SELECT * FROM product WHERE id='$product_id' LIMIT 1");
$product = mysqli_fetch_assoc($productQuery);

if (!$product) {
    die("Product not found");
}

$_SESSION['buy_now'] = [
    [
        "product_id" => $product['id'],
        "name" => $product['name'],
        "price" => $product['price'],
        "quantity" => 1,
        "size" => $size
    ]
];

header("Location: checkout.php?type=buy_now");
exit;