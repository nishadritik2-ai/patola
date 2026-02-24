<?php
ob_start();
include "config.php";
include "admin/connection.php";
$error = "";

/* ==============================
   LOGIN WITH PASSWORD
============================== */
if (isset($_POST['password_login'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($con, "SELECT * FROM customer WHERE email='$email'");

    if (mysqli_num_rows($query) > 0) {

        $row = mysqli_fetch_assoc($query);

        if (password_verify($password, $row['password'])) {

            $_SESSION['customer_id'] = $row['id'];
            $_SESSION['customer_name'] = $row['name'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not registered.";
    }
}


/* ==============================
   LOGIN WITH OTP
============================== */
if (isset($_POST['send_otp'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);

    $check = mysqli_query($con, "SELECT * FROM customer WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {

        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        mysqli_query($con, "UPDATE customer SET otp='$otp', otp_expiry='$expiry' WHERE email='$email'");

        require "includes/mail_config.php";

        if (sendOTP($email, $otp)) {

            $_SESSION['otp_email'] = $email;
            header("Location: verify_otp.php");
            exit;
        } else {
            $error = "Failed to send OTP.";
        }
    } else {
        $error = "Email not registered.";
    }
}
?>

<?php include "header.php"; ?>

<div class="container py-5 cus-p">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-lg p-4 rounded-4 border-0">

                <h3 class="text-center mb-4 fw-bold">Customer Login</h3>

                <?php if ($error != "") { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control form-control-lg">
                    </div>

                    <div class="d-grid gap-2">

                        <button type="submit" name="password_login"
                            class="btn btn-dark btn-lg">
                            Login with Password
                        </button>

                        <button type="submit" name="send_otp"
                            class="btn btn-outline-primary btn-lg">
                            Login with OTP
                        </button>

                    </div>

                </form>

                <!-- <div class="text-center mt-3">
                    <a href="forgot_password.php">Forgot Password?</a>
                </div> -->

            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>