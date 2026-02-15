<?php include 'header.php' ?>
<div class="shop">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 commontop text-center">
                <h4>Blogs</h4>
                <div class="divider style-1 center">
                    <span class="hr-simple left"></span>
                    <i class="icofont icofont-ui-press hr-icon"></i>
                    <span class="hr-simple right"></span>
                </div>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur placerat nulla, in suscipit erat sodales id. Nullam ultricies eu turpis at accumsan. Mauris a sodales mi, eget lobortis nulla.</p> -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mainpage">
                <div class="form-row" style="justify-content: center;">
                    <?php
                    $sql = "SELECT * FROM blog";

                    $result = mysqli_query($con, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="product-thumb">
                                <div class="image">
                                    <a class="link" href="blog/<?php echo $row['slug'] ?>"><img src="admin/<?php echo $row['img'] ?>" alt="<?php echo $row['name'] ?>" title="<?php echo $row['name'] ?>" class="img-fluid" /></a>
                                    <div class="hoverbox">
                                        <!-- <a class="btn btn-theme btn-md" href="shopping-cart.html">Add To Cart</a> -->
                                    </div>
                                </div>
                                <div class="caption ">
                                    <a href="blog/<?php echo $row['slug'] ?>">
                                        <h4><?php echo $row['name'] ?></h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Single Product End -->
                    <!-- Product List End -->
                </div>

            </div>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>