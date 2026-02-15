<!DOCTYPE html>
<html>
<head>
<style>
body{font-family:Arial;background:#ecf0f1}
.checkout{width:70%;margin:auto;background:white;padding:30px;border-radius:10px}
input, select{width:100%;padding:10px;margin-bottom:15px;border-radius:6px;border:1px solid #ccc}
.place-order{background:#e67e22;color:white;padding:15px;border:none;width:100%;font-size:18px;border-radius:8px}
</style>
</head>
<body>

<div class="checkout">
<h2>Checkout</h2>

<form action="place_order.php" method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="text" name="phone" placeholder="Phone Number" required>
    <input type="text" name="address" placeholder="Address" required>
    <select name="payment_method">
        <option value="cod">Cash On Delivery</option>
        <option value="online">Online Payment</option>
    </select>
    <button class="place-order">Place Order</button>
</form>

</div>

</body>
</html>