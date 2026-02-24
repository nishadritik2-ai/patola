<?php include 'header.php';

$page_flname = $_REQUEST['file_name'];

// $flname1 = str_replace(".php", "", $page_flname);


// $flname = strtolower($flname1);
$sql = "SELECT * FROM product WHERE slug = '$page_flname'"; // Query to fetch product details

$result = $conn->query($sql);
while ($row = mysqli_fetch_assoc($result)) {
?>
    <style>
        #imageSlider {
            max-width: 430px;
            height: 400px;
            margin: auto;
        }

        /* Make inner & items full height */
        #imageSlider .carousel-inner,
        #imageSlider .carousel-item {
            height: 100%;
        }

        /* Image fit without zoom */
        #imageSlider .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Fix controls (no stretch) */
        #imageSlider .carousel-control-prev,
        #imageSlider .carousel-control-next {
            width: 50px;
            height: 50px;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Fix indicators position */
        #imageSlider .carousel-indicators {
            bottom: 10px;
        }
    </style>
    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb" style="background-image:url(img/product-ban.webp)">
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
                <div class="col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="0.2s">
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
                                <h5 class="mb-4" style="color:#97621e">Size Available : <?= $row['size'] ?></h5>
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
                <div class="col-lg-6 col-md-6 wow fadeInRight" data-wow-delay="0.2s" style="justify-items: center;">

    <div id="imageSlider"
        class="carousel slide rounded position-relative overflow-hidden"
        data-bs-ride="carousel">

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#imageSlider" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#imageSlider" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#imageSlider" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#imageSlider" data-bs-slide-to="3"></button>
            <button type="button" data-bs-target="#imageSlider" data-bs-slide-to="4"></button>
        </div>

        <!-- Slider Images -->
        <div class="carousel-inner">

            <!-- Main Image -->
            <div class="carousel-item active">
                <img src="admin/<?php echo $row['img']; ?>" class="d-block w-100" alt="">
            </div>

            <!-- Image 2 -->
            <?php if(!empty($row['img2'])) { ?>
            <div class="carousel-item">
                <img src="admin/<?php echo $row['img2']; ?>" class="d-block w-100" alt="">
            </div>
            <?php } ?>

            <!-- Image 3 -->
            <?php if(!empty($row['img3'])) { ?>
            <div class="carousel-item">
                <img src="admin/<?php echo $row['img3']; ?>" class="d-block w-100" alt="">
            </div>
            <?php } ?>

            <!-- Image 4 -->
            <?php if(!empty($row['img4'])) { ?>
            <div class="carousel-item">
                <img src="admin/<?php echo $row['img4']; ?>" class="d-block w-100" alt="">
            </div>
            <?php } ?>

            <!-- Static Size Image (Optional) -->
            <div class="carousel-item">
                <img src="img/pro-size.jpeg" class="d-block w-100" alt="">
            </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev"
            type="button"
            data-bs-target="#imageSlider"
            data-bs-slide="prev" style="background-color: black;">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next"
            type="button"
            data-bs-target="#imageSlider"
            data-bs-slide="next" style="background-color: black;">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>

</div>
            </div>
        </div>
    </div>
    <!-- About End -->


<?php }
include 'footer.php'; ?>