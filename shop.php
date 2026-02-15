<?php include 'header.php' ?>


<!-- Products Start -->
<div class="container-fluid service pb-5 cus-p">
    <div class="container pb-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 style="color:#000">Latest Product</h4>
            <h2 class="display-5 mb-4">Empowering Fashion, Elevating <br> Your Brand</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <?php

            $sql = "SELECT * FROM product";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="admin/<?php echo $row['img'] ?>" class="img-fluid rounded-top w-100" alt="">
                        </div>
                        <div style="text-align:center" class="rounded-bottom p-4">
                            <a href="product/<?php echo $row['slug'] ?>"><?php echo $row['name']  ?></a>
                            <p>₹<?php echo $row['price'] ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Products End -->


<?php include 'footer.php' ?>