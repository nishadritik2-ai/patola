<?php
include "admin/connection.php";
include "config_cashfree.php";

$order_id = $_GET['order_id'];

$headers = [
    "x-client-id: " . CASHFREE_CLIENT_ID,
    "x-client-secret: " . CASHFREE_CLIENT_SECRET,
    "x-api-version: 2022-09-01"
];

$url = str_replace("/orders", "/orders/$order_id", CASHFREE_API_URL);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if ($result['order_status'] == "PAID") {

    $user_id = $_SESSION['customer_id'];
    $order_date = date("Y-m-d H:i:s");

    $temp = $_SESSION['temp_order'];

    /* GET CART AGAIN */
    $query = mysqli_query($con, "
        SELECT c.*, p.name, p.price, p.img
        FROM carts c
        JOIN product p ON c.product_id = p.id
        WHERE c.user_id = '$user_id'
    ");

    $total = 0;
    $products = [];

    while ($row = mysqli_fetch_assoc($query)) {

        $total += $row['price'] * $row['quantity'];

        $products[] = [
            "product_id" => $row['product_id'],
            "name" => $row['name'],
            "img" => $row['img'],
            "price" => $row['price'],
            "quantity" => $row['quantity']
        ];
    }

    $product_json = mysqli_real_escape_string($con, json_encode($products));

    mysqli_query($con, "
        INSERT INTO orders 
        (customer_id, order_date, total_amount, status, payment_method, payment_status, shipping_address, product, requirement)
        VALUES 
        ('$user_id', '$order_date', '$total', 'Success', 'Cashfree', 'Paid', '{$temp['address']}', '$product_json', '{$temp['requirement']}')
    ");

    mysqli_query($con, "DELETE FROM carts WHERE user_id='$user_id'");
    unset($_SESSION['temp_order']);

    echo '
<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
Swal.fire({
    icon: "success",
    title: "Payment Successful!",
    text: "Your order has been placed successfully.",
    confirmButtonColor: "#27ae60"
}).then(() => {
    window.location = "index.php";
});
</script>
</body>
</html>
';

} else {

    echo '
<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
Swal.fire({
    icon: "error",
    title: "Payment Failed!",
    text: "Your transaction was not successful.",
    confirmButtonColor: "#d33"
}).then(() => {
    window.location = "checkout.php";
});
</script>
</body>
</html>
';
}