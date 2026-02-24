<?php
ob_start();
session_start();
require "connection.php";

if (!isset($_SESSION['admin_otp_email'])) {
    header("Location: admin-login.php");
    exit;
}

$email = $_SESSION['admin_otp_email'];
$error = "";

if (isset($_POST['verify'])) {

    $entered_otp = $_POST['otp'];

    $stmt = mysqli_prepare($conn, "SELECT id, otp, otp_expiry FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $db_otp, $expiry);
    mysqli_stmt_fetch($stmt);

    if ($entered_otp == $db_otp && strtotime($expiry) > time()) {

        // IMPORTANT: CLOSE STATEMENT FIRST
        mysqli_stmt_close($stmt);

        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $id];

        // Now safe to run new query
        $clear = mysqli_prepare($conn, "UPDATE users SET otp=NULL, otp_expiry=NULL WHERE email=?");
        mysqli_stmt_bind_param($clear, "s", $email);
        mysqli_stmt_execute($clear);
        mysqli_stmt_close($clear);

        unset($_SESSION['admin_otp_email']);

        header("Location: all-product.php");
        exit;

    } else {
        $error = "Invalid or expired OTP";
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            font-family: 'Segoe UI';
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            padding: 40px;
            width: 350px;
            border-radius: 16px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            font-weight: bold;
        }

        .error {
            background: rgba(255, 0, 0, 0.2);
            color: white;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Verify OTP</h2>

    <?php if($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="otp" placeholder="Enter 6-digit OTP" required maxlength="6">
        <button type="submit" name="verify">Verify & Login</button>
    </form>
</div>

</body>
</html>