<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #9d671e, #5c3a0f);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .login-card .card-body {
            padding: 40px;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-login {
            border-radius: 10px;
            font-weight: 600;
        }

        .login-title {
            font-weight: 700;
            margin-bottom: 25px;
        }

        .form-text a {
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="card login-card">
        <div class="card-body">
            <h3 class="text-center login-title">Login</h3>

            <form action="#" method="POST">
                
                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <!-- Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-login">Login</button>
                </div>

                <!-- Register Link -->
                <div class="text-center mt-3 form-text">
                    Don’t have an account? <a href="register.php">Register</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reprehenderit quo sapiente rem ducimus neque voluptatibus? Non saepe assumenda quae vel dicta temporibus dolores quam recusandae laudantium explicabo sint reiciendis ullam praesentium tenetur est ex amet minus ipsam reprehenderit error similique dolorum, voluptas excepturi! Eaque, minima ullam tempora cumque beatae quas?