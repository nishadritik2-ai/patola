<?php
require_once 'connection.php';


/* ================= FETCH ALL ORDERS ================= */
$orderQuery = mysqli_query($con, "
    SELECT * FROM orders 
    ORDER BY id DESC
");
?>

<?php include 'header.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="container py-5">

        <h2 class="text-center mb-4 page-title">All Orders</h2>

        <?php if (mysqli_num_rows($orderQuery) > 0) { ?>

            <div class="accordion" id="orderAccordion">

                <?php
                $index = 0;
                while ($order = mysqli_fetch_assoc($orderQuery)):

                    $index++;
                    $statusClass = "badge-pending";
                    if ($order['status'] == "Completed") $statusClass = "badge-completed";
                    if ($order['status'] == "Cancelled") $statusClass = "badge-cancelled";
                ?>

                    <div class="accordion-item order-card">

                        <h2 class="accordion-header" id="heading<?= $index ?>">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse<?= $index ?>"
                                aria-expanded="false">

                                <div class="w-100 d-flex justify-content-between align-items-center">

                                    <div>
                                        <strong>Order #<?= $order['id'] ?></strong>
                                        <span class="ms-3 text-muted">
                                            <?= date("d M Y", strtotime($order['created_at'])) ?>
                                        </span>
                                    </div>

                                    <div class="text-end">
                                        <span class="badge badge-status <?= $statusClass ?>">
                                            <?= $order['status'] ?>
                                        </span>

                                        <span class="ms-3 fw-bold">
                                            ₹<?= number_format($order['total_amount'], 2) ?>
                                        </span>
                                    </div>

                                </div>

                            </button>
                        </h2>

                        <div id="collapse<?= $index ?>"
                            class="accordion-collapse collapse"
                            data-bs-parent="#orderAccordion">

                            <div class="accordion-body">

                                <!-- ORDER META INFO -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p><strong>Customer ID:</strong> <?= $order['customer_id'] ?></p>
                                        <p><strong>Payment Method:</strong> <?= $order['payment_method'] ?></p>
                                        <p><strong>Payment Status:</strong> <?= $order['payment_status'] ?></p>
                                    </div>

                                    <div class="col-md-6">
                                        <p><strong>Shipping Address:</strong></p>
                                        <p><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                                    </div>
                                </div>

                                <hr>

                                <!-- PRODUCT LIST -->
                                <h6 class="mb-3">Products</h6>

                                <?php
                                $products = json_decode($order['product'], true);

                                if (!empty($products)):
                                    foreach ($products as $item):
                                ?>

                                        <div class="product-box d-flex justify-content-between align-items-center">

                                            <div>
                                                <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                                                <small>
                                                    Qty: <?= $item['quantity'] ?> |
                                                    Price: ₹<?= $item['price'] ?>
                                                </small>
                                            </div>

                                            <div>
                                                <strong>₹<?= number_format($item['total'], 2) ?></strong>
                                            </div>

                                        </div>

                                    <?php
                                    endforeach;
                                else:
                                    ?>

                                    <p class="text-muted">No product data available</p>

                                <?php endif; ?>

                                <hr>

                                <!-- TOTAL SECTION -->
                                <div class="d-flex justify-content-between">
                                    <h5>Total Amount</h5>
                                    <h5>₹<?= number_format($order['total_amount'], 2) ?></h5>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>

            </div>

        <?php } else { ?>

            <div class="alert alert-info text-center">
                No orders found.
            </div>

        <?php } ?>

    </div>
</main>

<?php include 'footer.php'; ?>