
<?php

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $category = $_POST['category'];
    $des = $_POST['des'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $file = time() . $_FILES['image']['name'];
    $tmpname = $_FILES['image']['tmp_name'];
    $folder = 'images/';
    $fileurl = $folder . $file;

    $sql = "INSERT INTO `product`(`cid`, `name`, `slug`, `img`, `des`, `price`, `stock`) VALUES ('$category','$name','$slug','$fileurl','$des','$price','$stock')";

    // $sql = "INSERT INTO `product`(`category-id`, `name`, `slug`, `img`, `des`,) VALUES ('$category','$name','$slug','$fileurl','$des')";
    $result = mysqli_query($con, $sql);
    if (move_uploaded_file($tmpname, $folder . $file)) {
        // echo "data insert sucessfully";
    } else echo "."; ?>
    <script>
        alert('product Added. Thank you<?php " . $name . " ?>');
        document.location.href = "index.php"
    </script>
<?php
}

?>

<?php include 'header.php' ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="container">
        <h2 class="text-center">Add New Product</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Name</label>
                <input name="name" type="text" placeholder="Enter product Name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">category</label>
                <select name="category" id="category" class="form-control">
                    <option value="0" selected>select category</option>
                    <?php
                    $sql = "SELECT * FROM category";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                        <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Price</label>
                <input name="price"
                    type="number"
                    step="0.01"
                    placeholder="Enter Product Price"
                    class="form-control"
                    id="exampleInputPrice"
                    required>
            </div>
            <div class="mb-3">
                <label for="exampleInputStock" class="form-label">Stock</label>
                <input name="stock" type="number" placeholder="Enter Stock Quantity" class="form-control">
            </div>

            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Slug</label>
                <input name="slug" type="text" placeholder="Enter Slug name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Image</label> <br>
                <input type="file" name="image" onchange="previewImage(this)">
                <img id="preview" height="100" style="display:none; margin-top:10px;">
            </div>
            <div class="mb-3">
                <label for="exampleInputpost" class="form-label">Description</label>
                <textarea id="editor" name="des"></textarea>
            </div>
            <!-- <div class="mb-3">
                    <label for="exampleInputpost" class="form-label">Description</label>
                    <textarea id="editor1" name="desc"></textarea>
                </div> -->
            <button href name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>