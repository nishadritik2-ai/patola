<?php
include "admin/connection.php";

/* ================= LOGIN CHECK ================= */
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['customer_id'];

/* ================= GET CUSTOMER DATA ================= */
$customerQuery = mysqli_query($con, "SELECT * FROM customer WHERE id='$user_id' LIMIT 1");
$customer = mysqli_fetch_assoc($customerQuery);

/* ================= CHECK CUSTOMER STATUS ================= */
if ($customer['status'] != 1) {
    echo "<script>
            alert('Your account is not yet approved');
            window.location='cart.php';
          </script>";
    exit;
}

/* ================= GET CART DATA ================= */
$query = mysqli_query($con, "
    SELECT c.*, p.name, p.price, p.img
    FROM carts c
    JOIN product p ON c.product_id = p.id
    WHERE c.user_id = '$user_id'
");

$total = 0;
$cart = [];

while ($row = mysqli_fetch_assoc($query)) {
    $cart[] = $row;
    $total += $row['price'] * $row['quantity'];
}

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

/* ================= HANDLE ORDER SUBMISSION ================= */
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $phone   = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $requirement = mysqli_real_escape_string($con, $_POST['requirement']);

    $payment_method = "razorpay";
    $status = "Pending";
    $payment_status = "Unpaid";
    $order_date = date("Y-m-d H:i:s");

    /* ===== PREPARE PRODUCT JSON ===== */
    $products = [];

    foreach ($cart as $item) {
        $products[] = [
            "product_id" => $item['product_id'],
            "name"       => $item['name'],
            "img"        => $item['img'],
            "price"      => $item['price'],
            "quantity"   => $item['quantity'],
            "total"      => $item['price'] * $item['quantity']
        ];
    }

    $product_json = mysqli_real_escape_string($con, json_encode($products));

    /* ===== INSERT ORDER ===== */
    mysqli_query($con, "
        INSERT INTO orders 
        (customer_id, order_date, total_amount, status, payment_method, payment_status, shipping_address, product,requirement)
        VALUES 
        ('$user_id', '$order_date', '$total', '$status', '$payment_method', '$payment_status', '$address', '$product_json','$requirement')
    ");

    /* ===== CLEAR CART ===== */
    mysqli_query($con, "DELETE FROM carts WHERE user_id='$user_id'");

    echo "<script>
            alert('Order data saved successfully');
            window.location='cart.php';
          </script>";
    exit;
}

?>

<?php include "header.php"; ?>

<style>
    body {
        background: #f5f6fa;
        font-family: Arial
    }

    .checkout-wrapper {
        width: 90%;
    }

    .card-box {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 20px
    }

    .item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px
    }

    .btn-order {
        width: 100%;
        padding: 12px;
        background: #27ae60;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px
    }

    @media(max-width:768px) {
        .row {
            flex-direction: column
        }
    }
</style>

<div class="checkout-wrapper container cus-p">
    <div class="row">

        <!-- LEFT COLUMN -->
        <div class="col-md-6">
            <div class="card-box">
                <h3>Checkout Details</h3>
                <form method="POST">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control"
                                value="<?= htmlspecialchars($customer['name'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control"
                                value="<?= htmlspecialchars($customer['phone'] ?? '') ?>" required>
                        </div>

                    </div>


                    <div class="form-group mb-3">
                        <label>Full Address</label>
                        <input type="text" name="address" class="form-control"
                            value="<?= htmlspecialchars($customer['address'] ?? '') ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Size</label>
                        <input type="text" name="requirement" class="form-control" placeholder="XS,S,M,L,XL,XXL"
                            value="<?= htmlspecialchars($customer['requirement'] ?? '') ?>" required>
                    </div>


                    <button type="submit" class="btn-order mt-3">
                        Place Order
                    </button>

                </form>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-6">
            <div class="card-box">
                <h3>Order Summary</h3>

                <?php foreach ($cart as $row): ?>
                    <div class="item">
                        <div>
                            <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                            <small>Qty: <?= $row['quantity'] ?></small>
                        </div>
                        <div>
                            ₹ <?= number_format($row['price'] * $row['quantity'], 2) ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <hr>

                <div class="summary-line">
                    <span>Subtotal</span>
                    <span>₹ <?= number_format($total, 2) ?></span>
                </div>

                <div class="summary-line">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>

                <hr>

                <div class="summary-line">
                    <strong>Total</strong>
                    <strong>₹ <?= number_format($total, 2) ?></strong>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include "footer.php"; ?>