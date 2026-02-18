<?php include 'header.php' ?>
<?php

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    // $category = $_POST['category'];
    // $des = $_POST['des'];
    // $desc = $_POST['desc'];
    $file = time() . $_FILES['image']['name'];
    $tmpname = $_FILES['image']['tmp_name'];
    $folder = 'images/';
    $fileurl = $folder . $file;

    $sql = "INSERT INTO `category`(`name`, `slug`, `img`) VALUES  ('$name','$slug','$fileurl')";

    $result = mysqli_query($con, $sql);
    if (move_uploaded_file($tmpname, $folder . $file)) {
        // echo "data insert sucessfully";
    } else echo "."; ?>

    <script>
        alert('category Added. Thank you<?php " . $name . " ?>');
        document.location.href = "index.php"
    </script>
<?php
}

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Product Category</label>
                <input name="name" type="text" placeholder="Enter product Name" class="form-control" id="exampleInputname">
            </div>
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Slug</label>
                <input name="slug" type="text" placeholder="Enter Slug name" class="form-control" id="exampleInputname">
            </div>
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Image</label> <br>
                <input type="file" name="image" onchange="previewImage(this)">
                <img id="preview" height="100" style="display:none; margin-top:10px;">
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php include 'footer.php' ?>