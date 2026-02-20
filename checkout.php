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
?>

<?php include "header.php"; ?>

<style>
body {
    background: #f5f6fa;
    font-family: Arial;
}
.checkout-wrapper {
    width: 90%;
}
.card-box {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    margin-bottom: 20px;
}
.item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}
.summary-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}
.btn-order {
    width: 100%;
    padding: 12px;
    background: #27ae60;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
}
</style>

<div class="checkout-wrapper container cus-p">
    <div class="row">

        <!-- LEFT COLUMN -->
        <div class="col-md-6">
            <div class="card-box">
                <h3>Checkout Details</h3>

                <form id="checkoutForm">

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
                        <input type="text" name="requirement" class="form-control"
                            placeholder="XS,S,M,L,XL,XXL"
                            value="<?= htmlspecialchars($customer['requirement'] ?? '') ?>" required>
                    </div>

                    <button type="button" onclick="payNow()" class="btn-order mt-3" id="payBtn">
                        Pay ₹ <?= number_format($total, 2) ?>
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



<!-- Cashfree SDK -->
<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>

<script>
async function payNow() {

    let btn = document.getElementById("payBtn");
    btn.innerHTML = "Processing...";
    btn.disabled = true;

    Swal.fire({
        title: "Creating Payment...",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const formData = new FormData(document.getElementById("checkoutForm"));

    try {
        let response = await fetch("create_cashfree_order.php", {
            method: "POST",
            body: formData
        });

        let data = await response.json();

        if (data.payment_session_id) {

            Swal.close();

            const cashfree = Cashfree({
                mode: "sandbox" // 🔥 CHANGE TO production WHEN LIVE ======================
            });

            cashfree.checkout({
                paymentSessionId: data.payment_session_id,
                redirectTarget: "_self"
            });

        } else {
            throw new Error("Unable to create payment");
        }

    } catch (error) {

        btn.innerHTML = "Pay Now";
        btn.disabled = false;

        Swal.fire({
            icon: "error",
            title: "Payment Error",
            text: "Something went wrong!"
        });
    }
}
</script>

<?php include "footer.php"; ?>