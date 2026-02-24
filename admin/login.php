<?php
ob_start();
session_start();
require "connection.php";

$error = "";

/* ===========================
   PASSWORD LOGIN
=========================== */
if (isset($_POST['password_login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {

        $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {

            mysqli_stmt_bind_result($stmt, $id, $hashedPassword);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashedPassword)) {

                session_regenerate_id(true);
                $_SESSION['user'] = ['id' => $id];

                header("Location: all-product.php");
                exit;

            } else {
                $error = "Invalid password";
            }

        } else {
            $error = "Admin not found";
        }
    } else {
        $error = "All fields required";
    }
}


/* ===========================
   OTP LOGIN
=========================== */
if (isset($_POST['send_otp'])) {

    $email = trim($_POST['email']);

    if (!empty($email)) {

        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {

            mysqli_stmt_bind_result($stmt, $id);
            mysqli_stmt_fetch($stmt);

            $otp = rand(100000, 999999);
            $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

            $update = mysqli_prepare($conn, "UPDATE users SET otp=?, otp_expiry=? WHERE id=?");
            mysqli_stmt_bind_param($update, "ssi", $otp, $expiry, $id);
            mysqli_stmt_execute($update);

            require "../includes/mail_config.php";

            if (sendOTP($email, $otp, "Admin Login OTP")) {

                $_SESSION['admin_otp_email'] = $email;
                header("Location: admin_verify_otp.php");
                exit;

            } else {
                $error = "Failed to send OTP";
            }

        } else {
            $error = "Admin not found";
        }

    } else {
        $error = "Email required";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            padding: 40px;
            width: 380px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            color: white;
            margin-bottom: 20px;
        }

        .card input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: none;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .btn-dark {
            background: #000;
            color: white;
        }

        .btn-outline {
            background: white;
            color: #000;
        }

        .error {
            background: rgba(255, 0, 0, 0.2);
            color: white;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Admin Login</h2>

    <?php if($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password">

        <button type="submit" name="password_login" class="btn btn-dark">
            Login with Password
        </button>

        <button type="submit" name="send_otp" class="btn btn-outline">
            Login with OTP
        </button>
    </form>
</div>

</body>
</html>