<?php include 'header.php' ?>
<section class="container-flud bg-dark text-light py-3 ">
    <div class="d-flex justify-content-between align-items-center" style="margin:0 30px">
        <h2> Our Latest Blog Category</h2>
        <a href="category.php" class="btn btn-primary " style="margin-left: 55%;">Add Blog Category</a>
        <!-- <a href="user.php" class="btn btn-primary">Add Product</a> -->
    </div>
</section>
<table class="table table-dark table-hover">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">slug</th>
            <th scope="col">photo</th>
            <th scope="col">action</th>
            <th scope="col">EDIT</th>

        </tr>
    </thead>
    <tbody>

        <?php

        $sql = "SELECT * FROM blogcategory";
        $result = mysqli_query($con, $sql);
        // if(while(mysqli_fetch_assoc($)))

        while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['slug'] ?></td>
                <td> <img src="<?php echo $row['img'] ?>" height="80px" /></td>
                <td><a href="delete.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">delete</a></td>
                <td><a href="catupdate.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">EDIT</a></td>
            </tr>
        <?PHP }
        ?>
    </tbody>
</table>

<?php include 'footer.php' ?>