<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "connection.php";

$id = intval($_GET['id']);

// Fetch existing product
$productQuery = mysqli_query($con, "SELECT * FROM product WHERE id=$id");
$product = mysqli_fetch_assoc($productQuery);

if (isset($_POST['submit'])) {

    $name  = mysqli_real_escape_string($con, $_POST['name']);
    $slug  = mysqli_real_escape_string($con, $_POST['slug']);
    $des   = mysqli_real_escape_string($con, $_POST['des']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $stock = mysqli_real_escape_string($con, $_POST['stock']);
    $size  = mysqli_real_escape_string($con, $_POST['size']);

    $folder = "images/";

    // ================= MAIN IMAGE =================
    $img1 = $product['img'];
    if (!empty($_FILES['image']['name'])) {
        $file1 = time() . "_1_" . $_FILES['image']['name'];
        $img1 = $folder . $file1;
        move_uploaded_file($_FILES['image']['tmp_name'], $img1);

        if (!empty($product['img']) && file_exists($product['img'])) {
            unlink($product['img']);
        }
    }

    // ================= IMAGE 2 =================
    $img2 = $product['img2'];
    if (!empty($_FILES['image2']['name'])) {
        $file2 = time() . "_2_" . $_FILES['image2']['name'];
        $img2 = $folder . $file2;
        move_uploaded_file($_FILES['image2']['tmp_name'], $img2);

        if (!empty($product['img2']) && file_exists($product['img2'])) {
            unlink($product['img2']);
        }
    }

    // ================= IMAGE 3 =================
    $img3 = $product['img3'];
    if (!empty($_FILES['image3']['name'])) {
        $file3 = time() . "_3_" . $_FILES['image3']['name'];
        $img3 = $folder . $file3;
        move_uploaded_file($_FILES['image3']['tmp_name'], $img3);

        if (!empty($product['img3']) && file_exists($product['img3'])) {
            unlink($product['img3']);
        }
    }

    // ================= IMAGE 4 =================
    $img4 = $product['img4'];
    if (!empty($_FILES['image4']['name'])) {
        $file4 = time() . "_4_" . $_FILES['image4']['name'];
        $img4 = $folder . $file4;
        move_uploaded_file($_FILES['image4']['tmp_name'], $img4);

        if (!empty($product['img4']) && file_exists($product['img4'])) {
            unlink($product['img4']);
        }
    }

    // ================= UPDATE QUERY =================
    $updateQuery = "UPDATE product SET
        name='$name',
        slug='$slug',
        price='$price',
        stock='$stock',
        size='$size',
        des='$des',
        img='$img1',
        img2='$img2',
        img3='$img3',
        img4='$img4'
        WHERE id=$id";

    $update = mysqli_query($con, $updateQuery);

    if ($update) {
        echo "<script>
                alert('Product Updated Successfully');
                window.location.href='all-product.php';
              </script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<?php include 'header.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="container">
        <h2>Update Product</h2>

        <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input name="name" type="text" value="<?php echo $product['name']; ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input name="price" type="number" step="0.01"
                    value="<?php echo $product['price']; ?>"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Size</label>
                <input name="size" type="text"
                    value="<?php echo $product['size']; ?>"
                    class="form-control">
            </div>

            <div class="mb-3 d-none">
                <input name="stock" value="<?php echo $product['stock']; ?>" type="number">
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input name="slug" type="text"
                    value="<?php echo $product['slug']; ?>"
                    class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6"> <!-- MAIN IMAGE -->
                    <div class="mb-3">
                        <label>Main Image</label><br>
                        <input type="file" name="image" onchange="previewImage(this,'preview1')">
                        <br>
                        <img src="<?php echo $product['img']; ?>" height="100">
                        <br>
                        <img style="display:none; margin-top:10px;" height="100" id="preview1">
                    </div>
                </div>
                <div class="col-md-6"><!-- IMAGE 2 -->
                    <div class="mb-3">
                        <label>Image 2</label><br>
                        <input type="file" name="image2" onchange="previewImage(this,'preview2')">
                        <br>
                        <img src="<?php echo $product['img2']; ?>" height="100">
                        <br>
                        <img style="display:none; margin-top:10px;" height="100" id="preview2">
                    </div>
                </div>
                <div class="col-md-6"><!-- IMAGE 3 -->
                    <div class="mb-3">
                        <label>Image 3</label><br>
                        <input type="file" name="image3" onchange="previewImage(this,'preview3')">
                        <br>
                        <img src="<?php echo $product['img3']; ?>" height="100">
                        <br>
                        <img style="display:none; margin-top:10px;" height="100" id="preview3">
                    </div>
                </div>
                <div class="col-md-6"><!-- IMAGE 4 -->
                    <div class="mb-3">
                        <label>Image 4</label><br>
                        <input type="file" name="image4" onchange="previewImage(this,'preview4')">
                        <br>
                        <img src="<?php echo $product['img4']; ?>" height="100">
                        <br>
                        <img style="display:none; margin-top:10px;" height="100" id="preview4">
                    </div>
                </div>
            </div>








            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="des" id="editor" class="form-control"><?php echo $product['des']; ?></textarea>
            </div>

            <button name="submit" type="submit" class="btn btn-primary">Update</button>

        </form>
    </div>
</main>

<?php include 'footer.php'; ?>