<?php include 'header.php'; ?>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <h2 class="mb-4">Dashboard Overview</h2>
    <div class="row g-4">
        <!-- Total Order Amount -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Order Amount</h6>
                        <h3 class="mb-0">₹<?= number_format($totalAmount, 2) ?></h3>
                    </div>
                    <div class="stat-icon text-primary">
                        <i class="bi bi-currency-rupee"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Orders -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Today's Orders</h6>
                        <h3 class="mb-0"><?= $todayOrders ?></h3>
                    </div>
                    <div class="stat-icon text-success">
                        <i class="bi bi-cart-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Users</h6>
                        <h3 class="mb-0"><?= $userCount ?></h3>
                    </div>
                    <div class="stat-icon text-info">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inactive Users -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Inactive Users</h6>
                        <h3 class="mb-0"><?= $inactiveUsers ?></h3>
                    </div>
                    <div class="stat-icon text-warning">
                        <i class="bi bi-person-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>