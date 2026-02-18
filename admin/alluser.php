<?php
require_once 'connection.php';

/* ================= HANDLE STATUS UPDATE (AJAX) ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id']) && isset($data['status'])) {

        $id = (int)$data['id'];
        $status = (int)$data['status'];

        $update = mysqli_query($con, "UPDATE customer SET status='$status' WHERE id='$id'");

        echo json_encode(["success" => $update ? true : false]);
        exit;
    }
}

/* ================= FETCH CUSTOMERS ================= */
$customers = [];
$res = mysqli_query($con, "SELECT * FROM customer ORDER BY created_at DESC");

while ($row = mysqli_fetch_assoc($res)) {
    $customers[] = $row;
}

/* Split into approved & pending */
$approved = array_filter($customers, fn($c) => $c['status'] == 1);
$pending  = array_filter($customers, fn($c) => $c['status'] == 0);
?>
<?php include 'header.php'; ?>
<style>
    /* Card Styling */
    .card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    /* Card Header */
    .card-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: #fff;
        font-weight: 600;
        font-size: 15px;
        padding: 14px 18px;
        border-bottom: none;
    }

    /* Badge Counter */
    .card-header .badge {
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 20px;
    }

    /* Table Styling */
    .table {
        margin-bottom: 0;
    }

    .table thead {
        background-color: #f8f9fa;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table th {
        font-weight: 600;
        color: #555;
    }

    .table tbody tr {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f1f5ff;
        transform: scale(1.01);
    }

    /* Buttons */
    .btn-approve {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        color: #fff;
        padding: 6px 14px;
        font-size: 13px;
        border-radius: 20px;
        transition: 0.3s;
    }

    .btn-approve:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }

    /* Block Button */
    .btn-block {
        background: linear-gradient(135deg, #dc3545, #ff6b6b);
        border: none;
        color: #fff;
        padding: 6px 14px;
        font-size: 13px;
        border-radius: 20px;
        transition: 0.3s;
    }

    .btn-block:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }

    /* Approved Badge */
    .badge-approved {
        background: linear-gradient(135deg, #28a745, #20c997);
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 20px;
        color: white;
        font-weight: 500;
    }

    /* Scrollbar Styling */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #d6d6d6;
        border-radius: 10px;
    }
</style>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="container py-5">
        <h2 class="mb-4 text-center">Customer Management</h2>

        <div class="row g-4">

            <!-- ================= APPROVED SECTION ================= -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <span><i class="bi bi-check-circle me-2"></i>Approved</span>
                        <span class="badge bg-success"><?= count($approved) ?></span>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($approved as $c): ?>
                                        <tr onclick='showModal(<?= json_encode($c) ?>)'>
                                            <td><?= htmlspecialchars($c['name']) ?></td>
                                            <td><?= htmlspecialchars($c['email']) ?></td>
                                            <td>
                                                <span class="badge badge-approved">Approved</span>
                                                <button class="btn-block ms-2"
                                                    onclick="updateStatus(event, <?= $c['id'] ?>, 0)">
                                                    Block
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ================= PENDING SECTION ================= -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <span><i class="bi bi-clock-history me-2"></i>Pending Approval</span>
                        <span class="badge bg-danger"><?= count($pending) ?></span>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($pending as $c): ?>
                                        <tr onclick='showModal(<?= json_encode($c) ?>)'>
                                            <td><?= htmlspecialchars($c['name']) ?></td>
                                            <td><?= htmlspecialchars($c['email']) ?></td>
                                            <td>
                                                <button class="btn-approve"
                                                    onclick="updateStatus(event, <?= $c['id'] ?>, 1)">
                                                    Approve
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <!-- ================= MODAL ================= -->
    <div class="modal fade" id="customerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="modalBody"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="modalActionBtn"></button>
                </div>

            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>