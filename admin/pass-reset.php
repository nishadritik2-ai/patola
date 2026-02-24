<?php
ob_start();
session_start();
require "connection.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (empty($email) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } 
    elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } 
    elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } 
    else {

        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_close($stmt);

            $update = mysqli_prepare($conn, "UPDATE users SET password=? WHERE email=?");
            mysqli_stmt_bind_param($update, "ss", $hashedPassword, $email);
            mysqli_stmt_execute($update);
            mysqli_stmt_close($update);

            $success = "Password reset successful. You can now login.";

        } else {
            $error = "Admin email not found.";
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Password Reset</title>
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
            color: #fff;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .card input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            outline: none;
        }

        .toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 14px;
            color: #333;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-primary {
            background: #000;
            color: white;
        }

        .error {
            background: rgba(255, 0, 0, 0.2);
            color: white;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .success {
            background: rgba(0, 255, 0, 0.2);
            color: white;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        a {
            display: block;
            margin-top: 10px;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Reset Admin Password</h2>

    <?php if($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="input-group">
            <input type="email" name="email" placeholder="Admin Email" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="New Password" required>
            <span class="toggle" onclick="togglePassword('password')">👁</span>
        </div>

        <div class="input-group">
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
            <span class="toggle" onclick="togglePassword('confirm_password')">👁</span>
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>

    </form>

    <a href="dashboard.php">Back </a>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}
</script>

</body>
</html>