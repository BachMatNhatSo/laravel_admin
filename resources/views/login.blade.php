<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AdminLTE 3 | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="index2.html"><b>Admin</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form id="idtable" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" id="password"
                            name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="captcha">
                            <span>{!! captcha_img('mini') !!} </span>
                            <button type="button" class="btn btn-danger reload" id="reload">&#x21bb;</button>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" id="captcha" name="captcha" class="form-control" placeholder="Captcha"
                            required>
                        @error('captcha')
                            <label for="" class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" id="btnsubmit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            function reloadCaptcha() {
                $.ajax({
                    type: 'GET',
                    url: 'reloadCaptcha',
                    success: function(data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            }
            $('#idtable').on('submit', function(e) {
                e.preventDefault();
                var formData = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                    captcha: $('#captcha').val(),
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/login',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.message === 'Login successful') {
                            Swal.fire({
                                title: "Login Success!!",
                                text: "You clicked the button!",
                                icon: "success"
                            }).then(function() {
                                window.location.href = '/';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Unexpected response',
                                text: 'An unexpected response was received. Please try again.'
                            });
                        }
                        // Reload captcha after form submission
                        reloadCaptcha();
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON
                            .errors.captcha) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login failed',
                                text: 'The captcha entered is incorrect. Please try again.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login failed',
                                text: 'The account or password is incorrect, please try again!'
                            });
                        }
                        // Reload captcha after form submission
                        reloadCaptcha();
                    }
                });
            });

            // Reload captcha when reload button is clicked
            $('#reload').click(function() {
                reloadCaptcha();
            });

        });
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>




</body>

</html>
