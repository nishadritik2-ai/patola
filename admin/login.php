<?php

session_start();
require "../connection.php";

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
                header("Location: dashboard.php");
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

<div class="card">
    <h2>Login</h2>

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
