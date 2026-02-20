<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<?php include 'header.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <div class="container">

        <!-- <div class="card bg-white  text-black mb-4 shadow">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <h4 class="mb-2 mb-md-0">Category</h4>
                <a href="category.php" class="btn btn-primary btn-sm">+ Add category</a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-secondary text-black">
                        <tr>
                            <th>ID</th>
                            <th>Product Category</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($con, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['slug']) ?></td>
                                <td>
                                    <img src="<?= $row['img'] ?>" class="img-thumbnail" width="80">
                                </td>
                                <td class="text-center">
                                    <a href="catupdate.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="catdelete.php?id=<?= $row['id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div> -->

        <!-- product SECTION -->
        <div class="card bg-white  text-black mb-4 shadow">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <h4 class="mb-2 mb-md-0">Latest products</h4>
                <a href="user.php" class="btn btn-primary btn-sm">+ Add product</a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-secondary text-black">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>stock</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM product";
                        $result = mysqli_query($con, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['price']) ?></td>
                                <td><?= htmlspecialchars($row['stock']) ?></td>
                                <td><?= htmlspecialchars($row['slug']) ?></td>
                                <td>
                                    <img src="<?= $row['img'] ?>" class="img-thumbnail" width="80">
                                </td>
                                <td class="text-center">
                                    <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- product SECTION -->




    </div>
</main>
<?php include 'footer.php'; ?>