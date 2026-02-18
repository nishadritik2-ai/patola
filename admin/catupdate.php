<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<?php include 'header.php' ?>
<?php
include "connection.php";

$id = intval($_GET['id']);

// Fetch existing data
$getData = mysqli_query($con, "SELECT * FROM category WHERE id=$id");
$row = mysqli_fetch_assoc($getData);

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);

    $folder = "images/";

    // ✅ Check if new image selected
    if (!empty($_FILES['image']['name'])) {

        $file = time() . "_" . $_FILES['image']['name'];
        $tmpname = $_FILES['image']['tmp_name'];
        $fileurl = $folder . $file;

        move_uploaded_file($tmpname, $fileurl);

        // Optional: delete old image
        if (!empty($row['img']) && file_exists($row['img'])) {
            unlink($row['img']);
        }

        $sql = "UPDATE category 
                SET name='$name',
                    slug='$slug',
                    img='$fileurl'
                WHERE id=$id";
    } else {

        $sql = "UPDATE category 
                SET name='$name',
                    slug='$slug'
                WHERE id=$id";
    }

    $update = mysqli_query($con, $sql);

    if ($update) {
        echo "<script>
                alert('Category Updated Successfully');
                window.location.href='all-product.php';
              </script>";
        exit();
    } else {
        echo mysqli_error($con);
    }
}
?>

<?php
$sql = "SELECT * FROM category Where id=$id";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) { ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        <div class="container">
            <h2>Update category</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label"> category Name</label>
                    <input name="name" value="<?php echo $row['name'] ?>" type="text" placeholder="Enter categroy Name" class="form-control" id="exampleInputname">
                </div>
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">category Slug</label>
                    <input name="slug" value="<?php echo $row['slug'] ?>" type="text" placeholder="Enter category Slug name" class="form-control" id="exampleInputname">
                </div>
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">Image</label> <br>
                    <input type="file" name="image">
                    <img src="<?php echo $row['img'] ?>" height="100">
                </div>
                
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>


<?php
}
?>

<?php include 'footer.php' ?>