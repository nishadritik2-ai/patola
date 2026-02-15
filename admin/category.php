<?php include 'header.php' ?>
<?php

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    // $category = $_POST['category'];
    // $des = $_POST['des'];
    // $desc = $_POST['desc'];
    $file = time().$_FILES['image']['name'];
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .cke_notification_warning {
            display: none;
        }
    </style>

    <style>
        section {
            padding: 50px 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 700px;
        }

        form {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 6px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        input[type="file"] {
            padding: 6px;
        }

        img {
            display: block;
            margin: 10px 0 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button.btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.2s;
        }

        button.btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-1px);
        }

        .mb-3 {
            margin-bottom: 20px;
        }
    </style>

    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            const preview = document.getElementById("preview");

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = "block";
            }
        }
    </script>

</head>

<body>
    <section >
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
    </section>

    <script>
        // CKEDITOR.replace('editor');
        // CKEDITOR.replace('editor1');
    </script>

</body>

</html>