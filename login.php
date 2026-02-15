<?php
session_start();
include "header.php";

// Error reporting (optional during development)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {

        echo "<script>alert('All fields are required!');</script>";

    } else {

        $sql = "SELECT * FROM customer WHERE email='$email'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['password'])) {

                $_SESSION['customer_id'] = $row['id'];
                $_SESSION['customer_name'] = $row['name'];

                echo "<script>
                        alert('Login Successful!');
                        window.location='index.php';
                      </script>";

            } else {
                echo "<script>alert('Incorrect Password!');</script>";
            }

        } else {
            echo "<script>alert('Email not registered!');</script>";
        }
    }
}
?>



<section>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center py-5 cus-p">

            <div class="col-lg-6 col-md-6">
                <img src="img/draw2.webp" class="img-fluid" alt="Sample image">
            </div>

            <div class="col-lg-6 col-md-6">
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
                                class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">
                            Login
                        </button>

                        <p class="small fw-bold mt-2 pt-1 mb-0">
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
