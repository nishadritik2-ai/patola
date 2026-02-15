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
                window.location.href='index.php';
              </script>";
        exit();
    } else {
        echo mysqli_error($con);
    }
}
?>

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Form</title>

    <style>
        .cke_notification_warning {
            display: none;
        }
    </style>
    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>

</head>

<body>
    <?php
    $sql = "SELECT * FROM category Where id=$id";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) { ?>
        <?php include 'header.php' ?>
        <section style="margin: 50px;">
            <div class="container">
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
                    </div>
                    <img src="<?php echo $row['img'] ?>" height="100">
                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </section>

        <script>
            CKEDITOR.replace("editor", {
                // height: "100vh",
                // width: "100vw"
            });

            CKEDITOR.on("instanceReady", function(evt) {
                var instanceName = "editor";
                var editor = CKEDITOR.instances[instanceName];
                // editor.execCommand("maximize");
            });

            $(document).ready(function() {
                $("#page_effect").fadeIn(8000);
            });
        </script>
    <?php
    }
    ?>

    <?php include 'footer.php' ?>
</body>

</html>


<?php
