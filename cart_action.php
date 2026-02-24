<?php
include "admin/connection.php";

header("Content-Type: application/json");

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["status" => "error"]);
    exit;
}

$user_id = $_SESSION['customer_id'];

$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$size = isset($_POST['size']) ? mysqli_real_escape_string($con, $_POST['size']) : '';
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

/* ================= CART PAGE UPDATE (BY ID) ================= */
if ($cart_id > 0) {

    if ($quantity <= 0) {

        mysqli_query($con, "
            DELETE FROM carts 
            WHERE id='$cart_id' 
            AND user_id='$user_id'
        ");

    } else {

        mysqli_query($con, "
            UPDATE carts 
            SET quantity='$quantity' 
            WHERE id='$cart_id' 
            AND user_id='$user_id'
        ");
    }

}
/* ================= PRODUCT PAGE UPDATE ================= */
else {

    $check = mysqli_query($con, "
        SELECT id FROM carts 
        WHERE user_id='$user_id'
        AND product_id='$product_id'
        AND size='$size'
    ");

    if ($quantity <= 0) {

        mysqli_query($con, "
            DELETE FROM carts 
            WHERE user_id='$user_id'
            AND product_id='$product_id'
            AND size='$size'
        ");

    } else {

        if (mysqli_num_rows($check) > 0) {

            mysqli_query($con, "
                UPDATE carts 
                SET quantity='$quantity'
                WHERE user_id='$user_id'
                AND product_id='$product_id'
                AND size='$size'
            ");

        } else {

            mysqli_query($con, "
                INSERT INTO carts (user_id, product_id, size, quantity)
                VALUES ('$user_id', '$product_id', '$size', '$quantity')
            ");
        }
    }
}

/* ===== UPDATE CART COUNT ===== */
$countQuery = mysqli_query($con, "
    SELECT SUM(quantity) as total 
    FROM carts 
    WHERE user_id='$user_id'
");

$countData = mysqli_fetch_assoc($countQuery);

echo json_encode([
    "status" => "updated",
    "cart_count" => $countData['total'] ?? 0
]);