 <!-- Footer Start -->
 <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
     <div class="container py-5 border-start-0 border-end-0" style="border: 1px solid; border-color: rgb(255, 255, 255, 0.08);">
         <div class="row g-5">
             <div class="col-md-3 col-lg-3 col-xl-3">
                 <div class="footer-item">
                     <a href="index.php" class="p-0">
                         <!-- <h4 class="text-white"><i class="fas fa-search-dollar me-3"></i>Stocker</h4> -->
                         <img src="img/logo2.png" style="width: 180px;" alt="Logo">
                     </a>
                     <p class="mb-4">Step into style with Saanjh – Where fashion speaks tradition with a modern twist.</p>

                 </div>
             </div>
             <div class="col-md-3 col-lg-3 col-xl-3">
                 <div class="footer-item">
                     <h4 class="text-white mb-4">Quick Links</h4>
                     <a href=""><i class="fas fa-angle-right me-2"></i>Home</a>
                     <a href="about.php"><i class="fas fa-angle-right me-2"></i> About Us</a>

                     <a href="contact.php"><i class="fas fa-angle-right me-2"></i> Contact us</a>
                 </div>
             </div>
             <div class="col-md-3 col-lg-3 col-xl-3">
                 <div class="footer-item">
                     <h4 class="text-white mb-4">Products</h4>
                     <?php

                        $sql = "SELECT * FROM product LIMIT 5";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                         <a href="product/<?php echo $row['slug'] ?>">
                             <i class="fas fa-angle-right me-2"></i><?php echo $row['name']  ?>
                         </a>
                     <?php } ?>
                 </div>
             </div>
             <div class="col-md-3 col-lg-3 col-xl-3">
                 <div class="footer-item">
                     <h4 class="text-white mb-4">Contact Info</h4>
                     <div class="d-flex align-items-center">
                         <i class="fas fa-map-marker-alt text-primary me-3"></i>
                         <p class="text-white mb-0">8, 12, Block 11, Tilak Nagar, New Delhi, Delhi, 110018 ,India</p>
                     </div><br>

                     <div class="d-flex align-items-center">
                         <i class="fa fa-phone-alt text-primary me-3"></i>
                         <p class="text-white mb-0">+91 76918 60662</p>
                     </div>
                     <!-- <div class="d-flex align-items-center">
                         <i class="fas fa-envelope text-primary me-3"></i>
                         <p class="text-white mb-0">info@example.com</p>
                     </div> -->

                     <div class="d-flex">
                         <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="https://www.instagram.com/_patola_fashion_boutique_1x?igsh=MXQ2Z3FyeWR1NmM3ZA=="><i class="fab fa-instagram text-white"></i></a>
                         <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-facebook-f text-white"></i></a>
                         <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-twitter text-white"></i></a>
                         <a class="btn btn-primary btn-sm-square rounded-circle me-0" href="#"><i class="fab fa-linkedin-in text-white"></i></a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Footer End -->

 <!-- Copyright Start -->
 <div class="container-fluid copyright py-4">
     <div class="container">
         <div class="col-12">
             <div>
                 <div>
                     <p class="text-center text-white">Copyright © 2025-2026 All Right Reserved. Designed &amp; Developed By Fluxorae Pvt. Ltd</p>
                     <p class="mt-0 text-center text-white">Associated With: <a href="https://www.fluxorae.in/" target="blank"><img src="img/company.png" style="max-width: 50px;"></a></p>
                 </div>

             </div>
         </div>
     </div>
 </div>
 <!-- Copyright End -->


 <!-- Back to Top -->
 <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Product Enquiry</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <iframe src="https://webwebixytech.com/dev/demo/?email=saanjhapparel@gmail.com " frameborder="0" marginheight="0" marginwidth="0" width="100%" height="550px" title="Enquiry Form"></iframe>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">Save changes</button>
             </div>
         </div>
     </div>
 </div>


<script>

document.addEventListener("click", function(e) {

    let container = e.target.closest(".cart-container");
    if (!container) return;

    let product_id = container.dataset.product;
    let size = container.dataset.size;

    let qtySpan = container.querySelector(".qty");
    let addBtn = container.querySelector(".add-btn");
    let qtyBox = container.querySelector(".qty-box");

    /* ================= SIZE CLICK ================= */
    if (e.target.classList.contains("size-btn")) {

        container.querySelectorAll(".size-btn").forEach(btn => {
            btn.classList.remove("active");
        });

        e.target.classList.add("active");

        size = e.target.dataset.size;
        container.dataset.size = size;

        let qty = parseInt(e.target.dataset.qty);

        if (qty > 0) {
            qtySpan.innerText = qty;
            addBtn.style.display = "none";
            qtyBox.style.display = "flex";
        } else {
            qtySpan.innerText = "1";
            addBtn.style.display = "block";
            qtyBox.style.display = "none";
        }

        return;
    }

    let qty = parseInt(qtySpan.innerText);

    /* ================= ADD TO CART ================= */
    if (e.target.classList.contains("add-btn")) {

        if (!size) {
            alert("Please select size");
            return;
        }

        updateCart(product_id, size, 1, container);
        return;
    }

    /* ================= PLUS ================= */
    if (e.target.classList.contains("plus")) {
        updateCart(product_id, size, qty + 1, container);
        return;
    }

    /* ================= MINUS ================= */
    if (e.target.classList.contains("minus")) {
        updateCart(product_id, size, qty - 1, container);
        return;
    }

});


function updateCart(product_id, size, qty, container) {

    fetch("cart_action.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "product_id=" + product_id +
              "&size=" + size +
              "&quantity=" + qty
    })
    .then(res => res.json())
    .then(data => {

        if (data.status !== "updated") return;

        let qtySpan = container.querySelector(".qty");
        let addBtn = container.querySelector(".add-btn");
        let qtyBox = container.querySelector(".qty-box");
        let activeBtn = container.querySelector(".size-btn.active");

        if (qty <= 0) {

            if (activeBtn) activeBtn.dataset.qty = 0;

            addBtn.style.display = "block";
            qtyBox.style.display = "none";

        } else {

            if (activeBtn) activeBtn.dataset.qty = qty;

            qtySpan.innerText = qty;
            addBtn.style.display = "none";
            qtyBox.style.display = "flex";
        }

        let cartCount = document.getElementById("cartCount");
        if (cartCount) {
            cartCount.innerText = data.cart_count;
        }

    });
    

}


</script>


 <!-- JavaScript Libraries -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
 <script src="lib/wow/wow.min.js"></script>
 <script src="lib/easing/easing.min.js"></script>
 <script src="lib/waypoints/waypoints.min.js"></script>
 <script src="lib/counterup/counterup.min.js"></script>
 <script src="lib/lightbox/js/lightbox.min.js"></script>
 <script src="lib/owlcarousel/owl.carousel.min.js"></script>


 <!-- Template Javascript -->
 <script src="js/main.js"></script>
 </body>

 </html>