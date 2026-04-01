<?php 
session_start();
include("../server/connection.php");

$errorMessage = true 
?>

<!DOCTYPE html>
    <html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <?php include '../assets/styles.php';?>


</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form action="../auth/login.php" method="POST" id="loginFormValidation">
                                        <div class="form-group">
                                            <input name="username" type="text" class="form-control form-control-user"
                                                id="username" required="" 
                                                placeholder="Enter Username">
                                        </div>
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control form-control-user" required="" 
                                                id="password" placeholder="Enter Password">
                                        </div>
                                        <div class = "d-grid gap 2">
                                            <button name="login" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-user btn-block">Login</button>
                                         </div>
                                        <hr>
                                        <a href="index.php" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.php" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php include '../assets/scripts.php'; ?>

    <script>

        $(document).ready(function () {
            $('#loginFormValidation').validate({
                    rules: {
                        id: {
                            required: false,
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                if (typeof response === 'string') {
                                    var res = JSON.parse(response);
                                } else {
                                    var res = response; // If it's already an object
                                }

                                if (res.status === 'success') {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: res.message,
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.location.href = res.redirect;
                                    });
                                } else if (res.status === 'error') {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: res.message,
                                        icon: 'error',
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Error Occurred Please Try Again',
                                        icon: 'error',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                var errorMessage = 'An error occurred. Please try again later.';
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            });
    </script>

</body>

</html>