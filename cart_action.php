<?php
include "admin/connection.php";

header("Content-Type: application/json");

if(!isset($_SESSION['customer_id'])){
    echo json_encode(["status"=>"not_logged_in"]);
    exit;
}

$user_id = $_SESSION['customer_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'] ?? 1;

$check = mysqli_query($con,"SELECT * FROM carts WHERE user_id='$user_id' AND product_id='$product_id'");

if($quantity <= 0){
    mysqli_query($con,"DELETE FROM carts WHERE user_id='$user_id' AND product_id='$product_id'");
} else {
    if(mysqli_num_rows($check) > 0){
        mysqli_query($con,"UPDATE carts SET quantity='$quantity' WHERE user_id='$user_id' AND product_id='$product_id'");
    } else {
        mysqli_query($con,"INSERT INTO carts (user_id,product_id,quantity) VALUES ('$user_id','$product_id','$quantity')");
    }
}

$countQuery = mysqli_query($con,"SELECT SUM(quantity) as total FROM carts WHERE user_id='$user_id'");
$countData = mysqli_fetch_assoc($countQuery);

echo json_encode([
    "status"=>"updated",
    "cart_count"=> $countData['total'] ?? 0
]);