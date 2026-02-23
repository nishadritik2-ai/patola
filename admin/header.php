<?php
require_once 'connection.php'; // DB connection


// Dashboard stats
$totalAmount = 0;
$todayOrders = 0;
$userCount = 0;
// $inactiveUsers = 0;
$totalorders = 0;

// Total order amount
$res = $conn->query("SELECT SUM(total_amount) AS total FROM orders");
if ($res && $row = $res->fetch_assoc()) {
    $totalAmount = $row['total'] ?: 0;
}

// Today's orders
$today = date('Y-m-d');
$res = $conn->query("SELECT COUNT(*) AS cnt FROM orders WHERE DATE(order_date) = '$today'");
if ($res && $row = $res->fetch_assoc()) {
    $todayOrders = $row['cnt'];
}

// Total users
$res = $conn->query("SELECT COUNT(*) AS cnt FROM customer");
if ($res && $row = $res->fetch_assoc()) {
    $userCount = $row['cnt'];
}

// Inactive users (status = 0)
// $res = $conn->query("SELECT COUNT(*) AS cnt FROM customer WHERE status = 0");
// if ($res && $row = $res->fetch_assoc()) {
//     $inactiveUsers = $row['cnt'];
// }


// Inactive users (status = 0)
$res = $conn->query("SELECT COUNT(*) AS cnt FROM orders");
if ($res && $row = $res->fetch_assoc()) {
    $totalorders = $row['cnt'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }

        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            border-radius: .25rem;
            margin-bottom: .5rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, .15);
        }

        .card-stat {
            border: none;
            border-radius: 1rem;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
            transition: transform .2s;
        }

        .card-stat:hover {
            transform: translateY(-4px);
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: .8;
        }

        .cke_notifications_area {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
                <div class="text-center mb-4">
                    <h4 class="text-white">Admin Panel</h4>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="alluser.php"><i class="bi bi-people me-2"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order-data.php"><i class="bi bi-cart4 me-2"></i> Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="all-product.php"><i class="bi bi-box-seam me-2"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="bi bi-box-seam me-2"></i> Logout</a>
                    </li>
                </ul>
            </nav>