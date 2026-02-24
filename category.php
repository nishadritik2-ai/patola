<?php include "header.php";
$page_flname = $_REQUEST['c_name'];

// $flname1 = str_replace(".php", "", $page_flname);

// $flname = strtolower("$flname1");

$sql = "SELECT * FROM category WHERE slug = '$page_flname'";

$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $cid = $row['id'];
?>

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb" style="background-image:url(img/shop-ban.jpeg)">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">All Products</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
                <li class="breadcrumb-item active text-primary">Products</li>
            </ol>
        </div>
    </div>
    <!-- Header End -->
    <!-- Products Start -->
    <div class="container-fluid service py-5 cus-p">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 style="color:#000">Latest Product</h4>
                <h2 class="display-5 mb-4">Empowering Fashion, Elevating <br> Your Brand</h2>
            </div>
            <div class="row g-4 justify-content-center">
                <?php $sql = "SELECT * FROM product where cid='$cid'";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="admin/<?php echo $row['img'] ?>" class="img-fluid rounded-top w-100" alt="">
                            </div>
                            <div style="text-align:center" class="rounded-bottom p-4">
                                <a href="product/<?php echo $row['slug'] ?>"><?php echo $row['name']  ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Products End -->


<?php }
include 'footer.php' ?>