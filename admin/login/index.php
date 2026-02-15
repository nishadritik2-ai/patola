<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
    <h2>Welcome 👋</h2>

    <?php if (isset($_SESSION['user'])): ?>
        <a href="dashboard.php" class="btn">Dashboard</a>
        <a href="logout.php" class="btn danger">Logout</a>
    <?php else: ?>
        <a href="login.php" class="btn">Login</a>
    <?php endif; ?>
</div>

</body>
</html>
