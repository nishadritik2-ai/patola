<?php include 'header.php';

$page_flname = $_REQUEST['file_name'];

// $flname1 = str_replace(".php", "", $page_flname);


// $flname = strtolower($flname1);
$sql = "SELECT * FROM product WHERE slug = '$page_flname'"; // Query to fetch product details

$result = $conn->query($sql);
while ($row = mysqli_fetch_assoc($result)) {
?>

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb" style="background-image:url(img/pro/all0.jpg)">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?php echo $row['p_name'] ?></h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
                <li class="breadcrumb-item active text-primary">Products</li>
            </ol>
        </div>
    </div>
    <!-- Header End -->
    </div>
    <!-- Navbar & Hero End -->


    <!-- Abvout Start -->
    <div class="container-fluid about py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div>
                        <!-- <h4 style="color:#000"><?php echo $company ?></h4> -->
                        <h1 class="display-5 mb-4"><?php echo $row['name'] ?></h1>
                        <h2 class="display-5 mb-4"><?php echo $row['price'] ?></h2>
                        <?php echo $row['des'] ?><br>
                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Buy Now
                        </button> -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Buy Now
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Add to Cart
                        </button>

                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="bg-primary rounded position-relative overflow-hidden">
                        <img src="admin/<?php echo $row['img'] ?>" class="img-fluid rounded w-100" alt="">


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


<?php }
include 'footer.php'; ?>