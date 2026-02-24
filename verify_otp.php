<?php
include "config.php";
include "header.php";

if (!isset($_SESSION['otp_email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['otp_email'];

if (isset($_POST['verify'])) {

    $entered_otp = $_POST['otp'];

    $query = mysqli_query($con, "SELECT * FROM customer WHERE email='$email'");
    $row = mysqli_fetch_assoc($query);

    if ($row && $row['otp'] == $entered_otp && strtotime($row['otp_expiry']) > time()) {

        // Login user
        $_SESSION['customer_id'] = $row['id'];
        $_SESSION['customer_name'] = $row['name'];

        // Clear OTP
        mysqli_query($con, "UPDATE customer SET otp=NULL, otp_expiry=NULL WHERE email='$email'");

        unset($_SESSION['otp_email']);

        echo "<script>
            alert('Login Successful');
            window.location='index.php';
        </script>";
    } else {
        echo "<script>alert('Invalid or Expired OTP');</script>";
    }
}
?>

<div class="container py-5 cus-p">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow p-4 rounded-4 text-center">

                <h4>Enter OTP</h4>

                <form method="POST">
                    <input type="text" name="otp" class="form-control text-center mb-3"
                        placeholder="Enter 6-digit OTP" required maxlength="6">

                    <button type="submit" name="verify" class="btn btn-primary w-100">
                        Verify & Login
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>