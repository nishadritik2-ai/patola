<?php include "header.php" ?>

<?php

if (isset($_POST['submit'])) {

    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $phone    = mysqli_real_escape_string($con, $_POST['phone']);
    $address  = mysqli_real_escape_string($con, $_POST['address']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $status = 1;

    // Check Empty Fields
    if (empty($name) || empty($phone) || empty($address) || empty($email) || empty($_POST['password'])) {
        echo "<script>
Swal.fire({
    icon: 'warning',
    title: 'Missing Fields',
    text: 'All fields are required!'
});
</script>";
    } else {

        // Check if email already exists
        $checkEmail = mysqli_query($con, "SELECT * FROM customer WHERE email='$email'");

        if (mysqli_num_rows($checkEmail) > 0) {

            echo "<script>
Swal.fire({
    icon: 'error',
    title: 'Email Already Registered',
    text: 'Please use a different email address.'
});
</script>";
        } else {

            $sql = "INSERT INTO customer (name, phone, address, email, password, status) 
                    VALUES ('$name','$phone','$address','$email','$password','$status')";

            $result = mysqli_query($con, $sql);

            if ($result) {
                echo "<script>
Swal.fire({
    icon: 'success',
    title: 'Registration Successful!',
    text: 'Your account has been created successfully.',
    confirmButtonColor: '#3085d6'
}).then(() => {
    window.location='index.php';
});
</script>";
            } else {
                echo "<script>
Swal.fire({
    icon: 'error',
    title: 'Database Error',
    text: '" . mysqli_error($con) . "'
});
</script>";
            }
        }
    }
}
?>




<section>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center py-5 cus-p">
            <div class="col-lg-6 col-md-6">
                <img src="img/register.jpg"
                    style="width: 100%;" class="rounded" alt="Sample image">
            </div>
            <div class="col-lg-6 col-md-6">

                <!-- Logo Section -->
                <div class="text-center mb-4">
                    <img src="img/logo2.png" alt="Website Logo"
                        style="max-width:120px; height:auto;">
                </div>

                <!-- Heading Section -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Patola Fashion Boutique</h2>
                    <p style="color: black;">Register to get started</p>
                </div>

                <form action="" method="POST">

                    <!-- Full Name -->
                    <div class="form-outline mb-4">
                        <input name="name" type="text" id="name"
                            class="form-control form-control-lg"
                            placeholder="Enter your full name" required />
                        <label class="form-label" for="name">Full Name</label>
                    </div>

                    <!-- Phone -->
                    <div class="form-outline mb-4">
                        <input name="phone" type="tel" id="phone"
                            class="form-control form-control-lg"
                            placeholder="Enter your phone number" required />
                        <label class="form-label" for="phone">Phone Number</label>
                    </div>

                    <!-- Address -->
                    <div class="form-outline mb-4">
                        <textarea name="address" id="address"
                            class="form-control form-control-lg"
                            placeholder="Enter your address"
                            rows="3" required></textarea>
                        <label class="form-label" for="address">Address</label>
                    </div>

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

                    <div class="text-center mt-4">
                        <button name="submit" type="submit"
                            class="btn btn-primary btn-lg w-100">
                            Register
                        </button>

                        <p class="small fw-bold mt-3 mb-0">
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