<?php
include "admin/connection.php";

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['customer_id'];

$query = mysqli_query($con, "SELECT c.*, p.name, p.price, p.img FROM carts c JOIN product p ON c.product_id=p.id WHERE c.user_id='$user_id'");
$cartItems = mysqli_fetch_all($query, MYSQLI_ASSOC);
$total = 0;

?>
<?php include "header.php" ?>
<style>
    body {
        background: #f5f6fa;
        font-family: Arial
    }

    .wrapper {
        width: 90%;
        margin: 0 auto;
        display: flex;
        gap: 30px;
        flex-wrap: wrap
    }

    .left {
        flex: 2;
        background: #fff;
        padding: 25px;
        border-radius: 12px
    }

    .right {
        flex: 1;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        height: fit-content
    }

    .item {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding: 20px 0
    }

    .item img {
        width: 80px;
        margin-right: 20px;
        border-radius: 8px
    }

    .qty-box {
        display: flex;
        gap: 10px;
        align-items: center
    }

    .qty-box button {
        padding: 5px 12px;
        border: none;
        background: #eee
    }

    .remove {
        color: red;
        cursor: pointer;
        margin-left: 15px
    }

    .checkout-btn {
        width: 100%;
        padding: 15px;
        background: #27ae60;
        color: white;
        border: none;
        border-radius: 8px
    }

    .continue-btn {
        width: 100%;
        padding: 15px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    @media(max-width:768px) {
        .wrapper {
            flex-direction: column
        }
    }
</style>

<div class="wrapper cus-p mb-5">

    <?php if (count($cartItems) === 0): ?>
        <div style="text-align:center; margin: 50px auto;">
            <h2>Your Cart is Empty</h2>
            <a href="shop.php" class="continue-btn">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="left p-0 mt-2">
            <h2>Your Cart</h2>

            <?php foreach ($cartItems as $row):
                $total += $row['price'] * $row['quantity'];
            ?>

                <div class="item cart-container " data-product="<?= $row['product_id'] ?>">

                    <img src="admin/<?= $row['img'] ?>">

                    <div style="flex:1">
                        <h6><?= $row['name'] ?></h6>
                        ₹ <span class="price"><?= $row['price'] ?></span>
                    </div>

                    <div>
                        <div class="qty-box">
                            <button class="minus">-</button>
                            <span class="qty"><?= $row['quantity'] ?></span>
                            <button class="plus">+</button>
                        </div>

                        <div class="remove p-2 text-white mt-3 bg-danger">Remove</div>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>


        <div class="right">
            <h3>Order Summary</h3>
            <hr>
            <p>Subtotal: ₹ <span id="subtotal"><?= $total ?></span></p>
            <hr>
            <h4>Total: ₹ <span id="grandTotal"><?= $total ?></span></h4>
            <br>
            <a href="checkout.php">
                <button class="checkout-btn">Proceed to Checkout</button>
            </a>
        </div>
    <?php endif; ?>

</div>

<?php include "footer.php" ?>