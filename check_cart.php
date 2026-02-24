<?php
include "admin/connection.php";

header("Content-Type: application/json");

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["exists" => false]);
    exit;
}

$user_id = $_SESSION['customer_id'];
$product_id = intval($_POST['product_id']);
$size = $_POST['size'];

$query = mysqli_query($con, "
    SELECT quantity FROM carts 
    WHERE user_id='$user_id'
    AND product_id='$product_id'
    AND size='$size'
    LIMIT 1
");

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    echo json_encode([
        "exists" => true,
        "quantity" => $row['quantity']
    ]);
} else {
    echo json_encode(["exists" => false]);
}