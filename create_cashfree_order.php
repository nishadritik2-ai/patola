<?php
include "admin/connection.php";
include "config_cashfree.php";

header('Content-Type: application/json');

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["error" => "Login required"]);
    exit;
}

$user_id = $_SESSION['customer_id'];

$name = mysqli_real_escape_string($con, $_POST['name']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$requirement = mysqli_real_escape_string($con, $_POST['requirement']);

/* GET CART */
$query = mysqli_query($con, "
    SELECT c.*, p.price
    FROM carts c
    JOIN product p ON c.product_id = p.id
    WHERE c.user_id = '$user_id'
");

$total = 0;

while ($row = mysqli_fetch_assoc($query)) {
    $total += $row['price'] * $row['quantity'];
}

if ($total <= 0) {
    echo json_encode(["error" => "Cart empty"]);
    exit;
}

$orderId = "ORDER_" . time();

/* SAVE TEMP ORDER DETAILS IN SESSION */
$_SESSION['temp_order'] = [
    "name" => $name,
    "phone" => $phone,
    "address" => $address,
    "requirement" => $requirement
];

$data = [
    "order_id" => $orderId,
    "order_amount" => $total,
    "order_currency" => "INR",
    "customer_details" => [
        "customer_id" => (string)$user_id,
        "customer_phone" => $phone
    ],
    "order_meta" => [
        "return_url" => "http://localhost/patola/payment_success.php?order_id={order_id}"
    ]
];

$headers = [
    "Content-Type: application/json",
    "x-client-id: " . CASHFREE_CLIENT_ID,
    "x-client-secret: " . CASHFREE_CLIENT_SECRET,
    "x-api-version: 2022-09-01"
];

$ch = curl_init(CASHFREE_API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

echo $response;