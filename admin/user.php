<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include "connection.php";

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $category = $_POST['category'];
    $des = $_POST['des'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $size = $_POST['size'];   // ✅ Size added

    $file = time() . $_FILES['image']['name'];
    $tmpname = $_FILES['image']['tmp_name'];
    $folder = "images/";
    $fileurl = $folder . $file;

    // Image 2
    $file2 = !empty($_FILES['image2']['name']) ? time() . "_2_" . $_FILES['image2']['name'] : "";
    $fileurl2 = $file2 ? $folder . $file2 : "";

    // Image 3
    $file3 = !empty($_FILES['image3']['name']) ? time() . "_3_" . $_FILES['image3']['name'] : "";
    $fileurl3 = $file3 ? $folder . $file3 : "";

    // Image 4
    $file4 = !empty($_FILES['image4']['name']) ? time() . "_4_" . $_FILES['image4']['name'] : "";
    $fileurl4 = $file4 ? $folder . $file4 : "";

    $sql = "INSERT INTO product
    (cid,name,slug,img,img2,img3,img4,des,price,stock,size)
    VALUES
    ('$category','$name','$slug','$fileurl','$fileurl2','$fileurl3','$fileurl4','$des','$price','$stock','$size')";

    $result = mysqli_query($con, $sql);

    if ($result) {

        // Upload main image
        if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($_FILES['image']['tmp_name'], $fileurl);
        }

        // Upload image2
        if (!empty($_FILES['image2']['name'])) {
            move_uploaded_file($_FILES['image2']['tmp_name'], $fileurl2);
        }

        // Upload image3
        if (!empty($_FILES['image3']['name'])) {
            move_uploaded_file($_FILES['image3']['tmp_name'], $fileurl3);
        }

        // Upload image4
        if (!empty($_FILES['image4']['name'])) {
            move_uploaded_file($_FILES['image4']['tmp_name'], $fileurl4);
        }
?>
        <script>
            alert('Product Added Successfully!');
            window.location.href = 'all-product.php';
        </script>

<?php
    } else {
        echo "Database Error: " . mysqli_error($con);
    }
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
                <label for="exampleInputSize" class="form-label">Size</label>
                <input name="size" type="text" placeholder="Enter product Size" class="form-control" id="exampleInputSize">
            </div>
            <div class="mb-3 d-none">
                <label for="exampleInputStock" class="form-label">Stock</label>
                <input name="stock" type="number" placeholder="Enter Stock Quantity" class="form-control">
            </div>

            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Slug</label>
                <input name="slug" type="text" placeholder="Enter Slug name" class="form-control">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputName" class="form-label">Image</label> <br>
                        <input type="file" name="image" onchange="previewImage(this,'preview')">
                        <img id="preview" height="100" style="display:none; margin-top:10px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Image 2</label><br>
                        <input type="file" name="image2" onchange="previewImage(this,'preview2')">
                        <img id="preview2" height="100" style="display:none; margin-top:10px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Image 3</label><br>
                        <input type="file" name="image3" onchange="previewImage(this,'preview3')">
                        <img id="preview3" height="100" style="display:none; margin-top:10px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Image 4</label><br>
                        <input type="file" name="image4" onchange="previewImage(this,'preview4')">
                        <img id="preview4" height="100" style="display:none; margin-top:10px;">
                    </div>
                </div>
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