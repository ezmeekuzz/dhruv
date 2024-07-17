<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title;?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Admin template that can be used to build dashboards for CRM, CMS, etc." />
    <meta name="author" content="Potenza Global Solutions" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="<?=base_url();?>images/szs.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/vendors.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">
    <style>
        .full-background {
            background-image: url('<?=base_url();?>images/inner-prop-img.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 100vh; /* Ensures it covers the full viewport height */
        }
        .container-fluid.p-0, .row.no-gutters, .h-100 {
            height: 100vh; /* Ensures parent containers do not restrict height */
        }
    </style>
</head>
<body class="bg-white">
    <div class="app">
        <div class="app-wrap">
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="<?=base_url();?>assets/img/loader/loader.svg" alt="loader">
                    </div>
                </div>
            </div>
            <div class="app-contant">
                <div class="bg-white">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-lg-5 col-xxl-3 align-self-center order-2 order-sm-1">
                                <div class="d-flex align-items-center h-100-vh">
                                    <div class="login p-50">
                                        <h1 class="mb-2"><img src="<?=base_url();?>images/szs.png" style="width: 100%;" alt=""></h1>
                                        <p>Welcome back, please login to your account.</p>
                                        <form id="signIn" class="mt-3 mt-sm-5">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Email Address*</label>
                                                        <input type="text" class="form-control" name="emailaddress" id="emailaddress" placeholder="Email Address" />
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Password*</label>
                                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" />
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <button type="submit" class="btn btn-info text-uppercase" style="background: #053944;">Sign In</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-9 col-lg-7 bg-info o-hidden order-1 order-sm-2 full-background">
                                <div class="row align-items-center h-100">
                                    <div class="col-7 mx-auto ">
                                        <!-- Removed img element -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url();?>assets/js/vendors.js"></script>
    <script src="<?=base_url();?>assets/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#signIn').submit(function(event) {
                // Prevent default form submission
                event.preventDefault();

                // Get form data
                var emailaddress = $('#emailaddress').val();
                var password = $('#password').val();

                // Perform client-side validation
                if (emailaddress.trim() === '' || password.trim() === '') {
                    // Show error using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please fill in the required fields!',
                    });
                    return;
                }

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: '/admin/login/authenticate',
                    data: $('#signIn').serialize(), // Serialize form data
                    dataType: 'json',
                    beforeSend: function() {
                        // Show loading effect
                        Swal.fire({
                            title: 'Logging In...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            // Redirect upon successful login
                            Swal.fire({
                                icon: 'success',
                                title: 'Logged In',
                                text: response.message,
                                timer: 1000, // Display message for 3 seconds
                                timerProgressBar: true,
                                showConfirmButton: false // Hide the "OK" button
                            }).then((result) => {
                                // Redirect after Swal alert is closed
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.href = "/admin/dashboard";
                                }
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred while logging in. Please try again later.',
                        });
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
