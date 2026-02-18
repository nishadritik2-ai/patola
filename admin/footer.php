</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>

<script>
    function previewImage(input) {
        const file = input.files[0];
        const preview = document.getElementById("preview");

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        }
    }
</script>
<script>
    CKEDITOR.replace('editor');
    // CKEDITOR.replace('editor1');
</script>
<script>
    function showModal(customer) {

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

        if (customer.status == 0) {
            btn.className = "btn btn-success";
            btn.innerText = "Approve";
            btn.onclick = (e) => updateStatus(e, customer.id, 1);
        } else {
            btn.className = "btn btn-danger";
            btn.innerText = "Block";
            btn.onclick = (e) => updateStatus(e, customer.id, 0);
        }

        new bootstrap.Modal(document.getElementById('customerModal')).show();
    }

    function updateStatus(e, id, status) {
        e.stopPropagation();

        fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    status: status
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(status == 1 ? "Customer Approved Successfully" : "Customer Blocked Successfully");
                    location.reload();
                } else {
                    alert("Error updating status");
                }
            });
    }
</script>

</body>

</html>