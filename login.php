<?php
include "header.php";

// Error reporting (optional during development)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {

        echo "<script>
Swal.fire({
    icon: 'warning',
    title: 'Missing Fields',
    text: 'Please enter email and password.'
});
</script>";
    } else {

        $sql = "SELECT * FROM customer WHERE email='$email'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['password'])) {

                $_SESSION['customer_id'] = $row['id'];
                $_SESSION['customer_name'] = $row['name'];

                echo "<script>
Swal.fire({
    icon: 'success',
    title: 'Login Successful!',
    text: 'Welcome back!',
    confirmButtonColor: '#3085d6'
}).then(() => {
    window.location='index.php';
});
</script>";
            } else {
                echo "<script>
Swal.fire({
    icon: 'error',
    title: 'Incorrect Password',
    text: 'Please try again.'
});
</script>";
            }
        } else {
            echo "<script>
Swal.fire({
    icon: 'error',
    title: 'Email Not Found',
    text: 'This email is not registered.'
});
</script>";
        }
    }
}
?>



<section>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center py-5 cus-p  ">

            <div class="col-lg-6 col-md-6">
                <img src="img/login.webp" class="rounded" style="width: 100%;" alt="Sample image">
            </div>

            <div class="col-lg-6 col-md-6 ">

                <!-- Logo Section -->
                <div class="text-center mb-4">
                    <img src="img/logo2.png" alt="Website Logo"
                        style="max-width:220px; height:auto;">
                </div>

                <!-- Heading Section -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Patola Fashion Boutique</h2>
                    <p class="text-muted">Login to your account</p>
                </div>

                <form method="POST">

                    <!-- Email -->
                    <div class="form-outline mb-4">
                        <input name="email" type="email"
                            class="form-control form-control-lg"
                            placeholder="Enter a valid email address" required />
                        <label class="form-label">Email address</label>
                    </div>

                    <!-- Password -->
                    <div class="form-outline mb-3">
                        <input name="password" type="password"
                            class="form-control form-control-lg"
                            placeholder="Enter password" required />
                        <label class="form-label">Password</label>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button name="login" type="submit"
                            class="btn btn-primary btn-lg w-100">
                            Login
                        </button>

                        <p class="small fw-bold mt-3 mb-0 text-center">
                            Don't have an account?
                            <a href="register.php" class="link-danger">Register</a>
                        </p>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>

<?php include "footer.php"; ?>