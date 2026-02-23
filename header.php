<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php require "admin/connection.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="http://localhost/patola/">
    <title></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="canonical" href="">


    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="shortcut icon" type="image/x-icon" href="img/logo2.png">
    <link rel="icon" href="img/logo2.png" type="image/x-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="lib/animate/animate.min.css" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* for testimonial */
        .color {
            color: #000;
        }

        table {
            width: 100%;
        }

        td {
            padding: 7px 10px;
            border: 1px solid;
        }

        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
    <style>
        @media (min-width: 990px) and (max-width: 2400px) {
            .cus-p {
                padding-top: 150px !important;
            }
        }
    </style>

</head>

<body>


    <?php
    $cartCount = 0;
    if (isset($_SESSION['customer_id'])) {
        $uid = $_SESSION['customer_id'];
        $res = mysqli_query($con, "SELECT SUM(quantity) as total FROM carts WHERE user_id='$uid'");
        $data = mysqli_fetch_assoc($res);
        $cartCount = $data['total'] ?? 0;
    }
    ?>

    <style>
        .cart-icon {
            position: relative;
            font-size: 22px;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 3px 6px;
            border-radius: 50%;
        }
    </style>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid topbar bg-light px-5 d-none d-lg-block">
        <div class="row gx-0 align-items-center">
            <div class="col-lg-4 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-flex flex-wrap">
                    <!-- <a class="text-muted small me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Luanda, Angola</a>
                    <a href="tel:+01234567890" class="text-muted small me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+01234567890</a>
                    <a href="mailto:example@gmail.com" class="text-muted small me-0"><i class="fas fa-envelope text-primary me-2"></i>Example@gmail.com</a> -->
                    <p class="m-0" style="color: #fff;">Welcome To Patola Fashion Boutique</p>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-flex flex-wrap">
                    <a class="text-muted small me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>India</a>
                    <a href="tel:+91 76918 60662" class="text-muted small me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+91 76918 60662</a>
                    <!-- <a href="mailto:example@gmail.com" class="text-muted small me-0"><i class="fas fa-envelope text-primary me-2"></i>Example@gmail.com</a> -->
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <?php if (isset($_SESSION['customer_id'])) { ?>

                        <!-- USER DROPDOWN -->
                        <div class="dropdown">
                            <a class="btn btn-primary dropdown-toggle rounded-pill py-2 px-4 my-3 my-lg-0"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user me-2"></i>
                                <?php echo $_SESSION['customer_name']; ?>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="profile.php">Profile</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                                </li>
                            </ul>
                        </div>

                    <?php } else { ?>

                        <!-- REGISTER -->
                        <a href="register.php">
                            <small class="me-3 text-dark">
                                <i class="fa fa-user text-primary me-2"></i>Register
                            </small>
                        </a>

                        <!-- LOGIN -->
                        <a href="login.php"
                            class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0">
                            Login
                        </a>

                    <?php } ?>

                    <a href="cart.php" class="cart-icon">
                        🛒
                        <span class="cart-badge" id="cartCount"><?= $cartCount ?></span>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0" style="background-color:black;">
            <a href="index.php" class="navbar-brand p-0">
                <!-- <h1 class="text-primary"><i class="fas fa-search-dollar me-3"></i>Stocker</h1> -->
                <img src="img/logo1.png" style="max-height: 95px;" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="about.php" class="nav-item nav-link">About Us</a>
                    <a href="allcategory.php" class="nav-item nav-link">Categories</a>
                    <a href="shop.php" class="nav-item nav-link">Products</a>
                    <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                </div>

                <div class="mobile-data d-lg-none ">

                    <!-- MOBILE USER AREA -->
                    <div class="mobile-user-area d-flex align-items-center gap-3 mt-3">
                        <?php if (isset($_SESSION['customer_id'])) { ?>

                            <!-- USER AVATAR & NAME -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-light dropdown-toggle d-flex align-items-center gap-2"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">

                                    <span class="text-white fw-semibold"><?= htmlspecialchars($_SESSION['customer_name']) ?></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-sm">
                                    <li><a class="dropdown-item" href="profile.php"><i class="fa fa-user fa-fw me-2"></i>Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-sign-out-alt fa-fw me-2"></i>Logout</a></li>
                                </ul>
                            </div>

                        <?php } else { ?>

                            <!-- LOGIN & REGISTER BUTTONS -->
                            <a href="login.php" class="btn btn-sm btn-outline-light flex-fill">Login</a>
                            <a href="register.php" class="btn btn-sm btn-primary flex-fill">Register</a>

                        <?php } ?>

                        <!-- CART ICON -->
                        <a href="cart.php" class="cart-icon-mobile position-relative">
                            <i class="fas fa-shopping-bag fa-lg text-white"></i>
                            <?php if ($cartCount > 0) { ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.65rem;"><?= $cartCount ?></span>
                            <?php } ?>
                        </a>
                    </div>
                </div>
            </div>
        </nav>