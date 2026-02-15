<?php include "header.php" ?>

<?php

if (isset($_POST['submit'])) {

    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $phone    = mysqli_real_escape_string($con, $_POST['phone']);
    $address  = mysqli_real_escape_string($con, $_POST['address']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check Empty Fields
    if (empty($name) || empty($phone) || empty($address) || empty($email) || empty($_POST['password'])) {
        echo "<script>alert('All fields are required!');</script>";
    } 
    else {

        // Check if email already exists
        $checkEmail = mysqli_query($con, "SELECT * FROM customer WHERE email='$email'");

        if (mysqli_num_rows($checkEmail) > 0) {

            echo "<script>alert('Email already registered!');</script>";

        } else {

            $sql = "INSERT INTO customer (name, phone, address, email, password) 
                    VALUES ('$name','$phone','$address','$email','$password')";

            $result = mysqli_query($con, $sql);

            if ($result) {
                echo "<script>
                        alert('Registered Successfully!');
                        window.location='index.php';
                      </script>";
            } else {
                echo "<script>alert('Database Error: " . mysqli_error($con) . "');</script>";
            }
        }
    }
}
?>




<section>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center py-5 cus-p">
            <div class="col-lg-6 col-md-6">
                <img src="img/draw2.webp"
                    class="img-fluid" alt="Sample image">
            </div>
            <div class="col-lg-6 col-md-6">
                <form action="" method="POST">
                    <!-- Full Name -->
                    <div class="form-outline mb-4">
                        <input name="name" type="text" id="name" class="form-control form-control-lg"
                            placeholder="Enter your full name" />
                        <label class="form-label" for="name">Full Name</label>
                    </div>

                    <!-- Phone -->
                    <div class="form-outline mb-4">
                        <input name="phone" type="tel" id="phone" class="form-control form-control-lg"
                            placeholder="Enter your phone number" />
                        <label class="form-label" for="phone">Phone Number</label>
                    </div>

                    <!-- Address -->
                    <div class="form-outline mb-4">
                        <textarea name="address" id="address" class="form-control form-control-lg"
                            placeholder="Enter your address" rows="3"></textarea>
                        <label class="form-label" for="address">Address</label>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input name="email" type="email" id="form3Example3" class="form-control form-control-lg"
                            placeholder="Enter a valid email address" />
                        <label class="form-label" for="form3Example3">Email address</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <input name="password" type="password" id="form3Example4" class="form-control form-control-lg"
                            placeholder="Enter password" />
                        <label class="form-label" for="form3Example4">Password</label>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button name="submit" type="submit" class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>

                        <p class="small fw-bold mt-2 pt-1 mb-0">
                            Already have an account?
                            <a href="login.php" class="link-danger">Login</a>
                        </p>
                    </div>

                </form>

            </div>
        </div>
    </div>

</section>

<?php include "footer.php" ?>