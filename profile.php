<?php
include "header.php";

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

/* ================= UPDATE PROFILE ================= */
if (isset($_POST['update_profile'])) {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = $_POST['new_password'];

    // Email duplicate check (excluding current user)
    $checkEmail = mysqli_query($con, "SELECT id FROM customer WHERE email='$email' AND id!='$customer_id'");
    
    if (mysqli_num_rows($checkEmail) > 0) {
        echo "<script>alert('Email already in use!');</script>";
    } else {

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $updateQuery = "UPDATE customer SET 
                name='$name',
                phone='$phone',
                address='$address',
                email='$email',
                password='$hashed_password'
                WHERE id='$customer_id'";
        } else {
            $updateQuery = "UPDATE customer SET 
                name='$name',
                phone='$phone',
                address='$address',
                email='$email'
                WHERE id='$customer_id'";
        }

        if (mysqli_query($con, $updateQuery)) {
            $_SESSION['customer_name'] = $name;
            echo "<script>alert('Profile Updated Successfully!');</script>";
        } else {
            echo "<script>alert('Error: ".mysqli_error($con)."');</script>";
        }
    }
}

/* ================= FETCH USER ================= */
$userQuery = mysqli_query($con, "SELECT * FROM customer WHERE id='$customer_id'");
$user = mysqli_fetch_assoc($userQuery);

/* ================= FETCH ORDERS ================= */
$orderQuery = mysqli_query($con, "SELECT * FROM orders WHERE customer_id='$customer_id' ORDER BY id DESC");
?>

<style>
.dashboard-card {
    background: #ffffff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.sidebar-avatar {
    width: 80px;
    height: 80px;
    background: #9d671e;
    border-radius: 50%;
    color: #fff;
    font-size: 30px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
}

.order-item {
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    transition: 0.3s;
}

.order-item:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.badge-status {
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 12px;
}
</style>

<section class="py-5 cus-p" style="background:#f4f6f9;">
    <div class="container">
        <div class="row">

            <!-- LEFT SIDEBAR -->
            <div class="col-lg-4 mb-4">
                <div class="dashboard-card text-center">

                    <div class="sidebar-avatar">
                        <?php echo strtoupper(substr($user['name'],0,1)); ?>
                    </div>

                    <h5 class="mt-3"><?php echo $user['name']; ?></h5>
                    <p class="text-muted"><?php echo $user['email']; ?></p>

                    <hr>

                    <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
                    <p><strong>Address:</strong> <?php echo $user['address']; ?></p>

                    <a href="logout.php" class="btn btn-danger w-100 mt-3">
                        Logout
                    </a>

                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="col-lg-8">

                <!-- USER DETAILS EDIT -->
                <div class="dashboard-card mb-4">
                    <h5 class="mb-4">User Details</h5>

                    <form method="POST">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Full Name</label>
                                <input type="text" name="name" class="form-control"
                                       value="<?php echo $user['name']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control"
                                       value="<?php echo $user['phone']; ?>" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Address</label>
                                <textarea name="address" class="form-control"
                                          rows="2" required><?php echo $user['address']; ?></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="<?php echo $user['email']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>New Password</label>
                                <input type="password" name="new_password"
                                       class="form-control"
                                       placeholder="Leave blank to keep same">
                            </div>
                        </div>

                        <button type="submit" name="update_profile"
                                class="btn btn-primary w-100">
                            Update Profile
                        </button>

                    </form>
                </div>

                <!-- ORDERS SECTION -->
                <div class="dashboard-card">
                    <h5 class="mb-4">My Orders</h5>

                    <?php if(mysqli_num_rows($orderQuery) > 0){ ?>

                        <?php while($order = mysqli_fetch_assoc($orderQuery)){ ?>

                            <div class="order-item">
                                <div class="d-flex justify-content-between align-items-center">

                                    <div>
                                        <strong>Order #<?php echo $order['id']; ?></strong>
                                        <p class="mb-1 text-muted">
                                            <?php echo date("d M Y", strtotime($order['order_date'])); ?>
                                        </p>
                                        <small>Payment: <?php echo $order['payment_method']; ?></small>
                                    </div>

                                    <div class="text-end">
                                        <span class="badge bg-success badge-status">
                                            <?php echo $order['status']; ?>
                                        </span>
                                        <h6 class="mt-2">₹<?php echo $order['total_amount']; ?></h6>
                                    </div>

                                </div>
                            </div>

                        <?php } ?>

                    <?php } else { ?>

                        <div class="alert alert-info">
                            You have not placed any orders yet.
                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>
    </div>
</section>

<?php include "footer.php"; ?>
