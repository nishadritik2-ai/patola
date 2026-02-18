<?php include 'header.php';

$page_flname = $_REQUEST['file_name'];

// $flname1 = str_replace(".php", "", $page_flname);


// $flname = strtolower($flname1);
$sql = "SELECT * FROM product WHERE slug = '$page_flname'"; // Query to fetch product details

$result = $conn->query($sql);
while ($row = mysqli_fetch_assoc($result)) {
?>

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb" style="background-image:url(admin/<?php echo $row['img'] ?>)">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s"><?php echo $row['name'] ?></h4>
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
                        <h3 class="mb-4" style="color:#97621e"><i class="fas fa-rupee-sign"></i> <?php echo $row['price'] ?></h3>
                        <?php echo $row['des'] ?><br>
                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Buy Now
                        </button> -->
                        <div class="row g-2">
                            <div class="col-12 d-flex gap-2">
                                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Buy Now
                                </button> -->
                                <div class="cart-container" data-product="<?= $row['id'] ?>">
                                    <button class="add-btn btn btn-primary">Add to Cart</button>
                                    <div class="qty-box" style="display:none;padding: 5px 15px;border: 1px solid #000;border-radius: 21px;">
                                        <button class="minus btn btn-sm btn-outline-secondary" aria-label="Decrease quantity">−</button>
                                        <span class="qty mx-2">1</span>
                                        <button class="plus btn btn-sm btn-outline-secondary" aria-label="Increase quantity">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Add to Cart
                        </button> -->

                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.1s">
                    <div id="productSlider" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="bg-primary rounded position-relative overflow-hidden">
                                    <img src="admin/<?php echo $row['img'] ?>" class="img-fluid rounded w-100" alt="">
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="bg-primary rounded position-relative overflow-hidden">
                                    <img src="img/pro-size.jpeg" class="img-fluid rounded w-100" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- Optional controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#productSlider" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productSlider" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


<?php }
include 'footer.php'; ?>