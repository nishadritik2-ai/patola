<?php
include "admin/connection.php";
include "config.php";

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['order_id'])) {
    die("Invalid Order ID");
}

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

if ($result['order_status'] === "PAID") {

    $user_id = $_SESSION['customer_id'];
    $order_date = date("Y-m-d H:i:s");

    if (!isset($_SESSION['temp_order'])) {
        die("Session expired. Please contact support.");
    }

    $temp = $_SESSION['temp_order'];

    $total = $temp['total'];
    $products = $temp['cart'];

    $product_json = mysqli_real_escape_string($con, json_encode($products));
    $address = mysqli_real_escape_string($con, $temp['address']);

    /* ================= INSERT ORDER ================= */
    mysqli_query($con, "
        INSERT INTO orders 
        (customer_id, order_date, total_amount, status, payment_method, payment_status, shipping_address, product)
        VALUES 
        ('$user_id', '$order_date', '$total', 'Success', 'Cashfree', 'Paid', '$address', '$product_json')
    ");

    /* ================= CLEAR CART ================= */
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
?>