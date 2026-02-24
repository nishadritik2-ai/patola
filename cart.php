<?php
include "admin/connection.php";

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['customer_id'];

$query = mysqli_query($con, "
    SELECT c.*, p.name, p.price, p.img 
    FROM carts c 
    JOIN product p ON c.product_id = p.id 
    WHERE c.user_id = '$user_id'
");

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

                <div class="item cart-container"
                    data-id="<?= $row['id'] ?>">

                    <img src="admin/<?= $row['img'] ?>">

                    <div style="flex:1">
                        <h6><?= htmlspecialchars($row['name']) ?></h6>
                        <small>Size: <strong><?= htmlspecialchars($row['size']) ?></strong></small><br>
                        ₹ <span class="price"><?= $row['price'] ?></span>
                    </div>

                    <div>
                        <div class="qty-box">
                            <button class="minus">-</button>
                            <span class="qty"><?= $row['quantity'] ?></span>
                            <button class="plus">+</button>
                        </div>

                        <div class="remove p-2 text-white mt-3 bg-danger">
                            Remove
                        </div>
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

<script>

document.addEventListener("click", function(e){

    let container = e.target.closest(".cart-container");
    if(!container) return;

    let cart_id = container.getAttribute("data-id");
    let qtySpan = container.querySelector(".qty");
    let qty = parseInt(qtySpan.innerText);

    if(e.target.classList.contains("plus")){
        send(cart_id, qty + 1, container);
    }

    if(e.target.classList.contains("minus")){
        send(cart_id, qty - 1, container);
    }

    if(e.target.classList.contains("remove")){
        send(cart_id, 0, container);
    }

});

function send(cart_id, qty, container){

    fetch("cart_action.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"cart_id="+cart_id+"&quantity="+qty
    })
    .then(res=>res.json())
    .then(data=>{

        if(data.status === "updated"){

            if(qty <= 0){
    container.remove();
}else{
    container.querySelector(".qty").innerText = qty;
}

updateTotals(); // 🔥 ADD THIS LINE

        }else{
            console.log(data);
        }

    });
}

function updateTotals() {

    let subtotal = 0;

    document.querySelectorAll(".cart-container").forEach(item => {

        let price = parseFloat(item.querySelector(".price").innerText);
        let qty = parseInt(item.querySelector(".qty").innerText);

        subtotal += price * qty;
    });

    let sub = document.getElementById("subtotal");
    let grand = document.getElementById("grandTotal");

    if (sub) sub.innerText = subtotal.toFixed(2);
    if (grand) grand.innerText = subtotal.toFixed(2);
}

</script>

<?php include "footer.php" ?>