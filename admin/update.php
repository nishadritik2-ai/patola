<?php
include "connection.php";

$id = intval($_GET['id']);

// Fetch existing product
$sql = "SELECT * FROM product WHERE id=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {

    $name  = mysqli_real_escape_string($con, $_POST['name']);
    $slug  = mysqli_real_escape_string($con, $_POST['slug']);
    $des   = mysqli_real_escape_string($con, $_POST['des']);
    $price = mysqli_real_escape_string($con, $_POST['price']); // ✅ Added Price
    $stock = mysqli_real_escape_string($con, $_POST['stock']); // ✅ Added stock

    $folder = "images/";

    // ✅ If new image selected
    if (!empty($_FILES['image']['name'])) {

        $file = time() . "_" . $_FILES['image']['name'];
        $tmpname = $_FILES['image']['tmp_name'];
        $fileurl = $folder . $file;

        // Move new image
        move_uploaded_file($tmpname, $fileurl);

        // Delete old image (if exists)
        if (!empty($row['img']) && file_exists($row['img'])) {
            unlink($row['img']);
        }

        $sql = "UPDATE product 
                SET name='$name',
                    slug='$slug',
                    price='$price',   -- ✅ Price Added
                    stock='$stock',   -- ✅ Price Added
                    img='$fileurl',
                    des='$des'
                WHERE id=$id";
    } else {

        // Update without changing image
        $sql = "UPDATE product 
                SET name='$name',
                    slug='$slug',
                    price='$price',   -- ✅ Price Added
                    stock='$stock',   -- ✅ Price Added
                    des='$des'
                WHERE id=$id";
    }

    $update = mysqli_query($con, $sql);

    if ($update) {
        echo "<script>
                alert('Product Updated Successfully');
                window.location.href='index.php';
              </script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

?>

<?php include 'header.php' ?>
<?php
$sql = "SELECT * FROM product Where id=$id";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) { ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        <div class="container">
            <h2>Update Product</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">Name</label>
                    <input name="name" type="text" value="<?php echo $row['name'] ?> " class="form-control" id="exampleInputname">
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input name="price"
                        type="number"
                        step="0.01"
                        class="form-control"
                        value="<?php echo $row['price']; ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputStock" class="form-label">Stock</label>
                    <input name="stock" value="<?php echo $row['stock'] ?>" type="number" placeholder="Enter Stock Quantity" class="form-control" id="exampleInputStock">
                </div>

                <div class="mb-3">
                    <label for="exampleInputage" class="form-label">Slug</label>
                    <input name="slug" type="text" value="<?php echo $row['slug'] ?> " class="form-control" id="exampleInputage">
                </div>
                <div>
                    <label for="exampleInputage" class="form-label">image</label>
                    <input type="file" name="image">
                </div>
                <img src="<?php echo $row['img'] ?>" height="100">
                <div class="mb-3">
                    <label for="exampleInputpost" class="form-label">Description</label>
                    <textarea id="editor" name="des"><?php echo $row['des'] ?></textarea>
                </div>
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                <!-- <button type="submit" name="submit">Submit</button> -->
            </form>
        </div>
    </main>

<?php
}
?>

<?php include 'footer.php' ?>