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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{background:#f7f9fc}
.card{border:none;border-radius:1rem;box-shadow:0 0 20px rgba(0,0,0,.08);}
.card-header{background:#fff;border-bottom:1px solid #e9ecef;font-weight:600}
.badge-approved{background:#d1f2eb;color:#0f5132}
.badge-pending{background:#f8d7da;color:#842029}
.btn-approve{background:#198754;border:none;border-radius:.5rem;padding:.4rem 1rem;color:#fff}
.btn-block{background:#dc3545;border:none;border-radius:.5rem;padding:.4rem 1rem;color:#fff}
.btn-approve:hover{background:#157347}
.btn-block:hover{background:#bb2d3b}
</style>
</head>

<body>

<div class="container py-5">
<h2 class="mb-4 text-center">Customer Management</h2>

<div class="row g-4">

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function showModal(customer){

const body = `
<p><strong>Name:</strong> ${customer.name}</p>
<p><strong>Email:</strong> ${customer.email}</p>
<p><strong>Phone:</strong> ${customer.phone}</p>
<p><strong>Address:</strong> ${customer.address}</p>
<p><strong>Status:</strong>
<span class="badge ${customer.status==1?'badge-approved':'badge-pending'}">
${customer.status==1?'Approved':'Pending'}
</span></p>
`;

document.getElementById('modalBody').innerHTML = body;

const btn = document.getElementById('modalActionBtn');

if(customer.status == 0){
btn.className = "btn btn-success";
btn.innerText = "Approve";
btn.onclick = (e)=> updateStatus(e, customer.id, 1);
}else{
btn.className = "btn btn-danger";
btn.innerText = "Block";
btn.onclick = (e)=> updateStatus(e, customer.id, 0);
}

new bootstrap.Modal(document.getElementById('customerModal')).show();
}

function updateStatus(e, id, status){
e.stopPropagation();

fetch('',{
method:'POST',
headers:{'Content-Type':'application/json'},
body: JSON.stringify({id:id, status:status})
})
.then(res=>res.json())
.then(data=>{
if(data.success){
alert(status==1 ? "Customer Approved Successfully" : "Customer Blocked Successfully");
location.reload();
}else{
alert("Error updating status");
}
});
}
</script>

</body>
</html>
