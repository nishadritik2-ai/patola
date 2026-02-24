<?php

session_start();
require "connection.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {

        $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_bind_result($stmt, $id, $hashedPassword);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user'] = [
                    'id' => $id
                ];
                // header("Location: dashboard.php");
                header("Location: all-product.php");
                exit;
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "User not found";
        }
    } else {
        $error = "All fields are required";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <style>
        /* Body Background */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Card Styling */
        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 40px 35px;
            width: 350px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }

        /* Heading */
        .card h2 {
            color: #fff;
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* Input Fields */
        .card input {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: none;
            outline: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .card input:focus {
            box-shadow: 0 0 0 2px #ffffff80;
        }

        /* Button */
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #ffffff, #f1f1f1);
            color: #333;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Error Message */
        .error {
            background: rgba(255, 0, 0, 0.15);
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 15px;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card input {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: none;
            outline: none;
            font-size: 14px;
            box-sizing: border-box;
        }
    </style>
    <div class="card">
        <h2>Admin Login</h2>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button class="btn">Login</button>
        </form>
    </div>

</body>

</html>