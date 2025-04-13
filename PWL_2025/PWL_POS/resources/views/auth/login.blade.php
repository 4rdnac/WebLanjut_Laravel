<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pengguna</title>

    <!-- Google Fonts & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abel|Playfair+Display&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AdminLTE + SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <style>
        body {
            background-image: linear-gradient(to top, #a8edea 0%, #fed6e3 100%);
            background-attachment: fixed;
            font-family: 'Abel', sans-serif;
        }

        .login-box {
            width: 450px;
        }

        .card {
            border-radius: 10px;
            background-image: linear-gradient(-225deg, #E3FDF5 50%, #FFE6FA 50%);
            box-shadow: 0 9px 50px hsla(20, 67%, 75%, 0.31);
        }

        .card-header a {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #3e403f;
        }

        .login-box-msg {
            letter-spacing: 0.05em;
        }

        .form-control:focus {
            transform: translateX(2px);
            border-radius: 5px;
            box-shadow: none;
        }

        .btn-primary:hover {
            transform: translateY(3px);
            animation: ani9 0.4s ease-in-out infinite alternate;
        }

        @keyframes ani9 {
            0% {
                transform: translateY(3px);
            }

            100% {
                transform: translateY(5px);
            }
        }

        /* Change for left-side icons */
        .input-group-prepend .input-group-text {
            border-right: 0;
            background-color: #fff;
        }

        .input-group .form-control {
            border-left: 0;
        }

        /* Password field styling */
        .input-group-password {
            position: relative;
        }

        .input-group-password .form-control {
            padding-right: 35px;
            /* Make room for the eye icon */
        }

        /* Properly position the toggle icon inside the input */
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            cursor: pointer;
            color: #6c757d;
            background: transparent;
            border: none;
            outline: none;
            padding: 0;
        }

        /* Error message styling */
        .error-text {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1">PWL POS</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Login menggunakan username dan password</p>
                <form action="{{ url('login') }}" method="POST" id="form-login">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><span class="fas fa-user-circle"></span></div>
                            </div>
                            <input type="text" id="username" name="username" class="form-control"
                                placeholder="Username">
                        </div>
                        <small id="error-username" class="text-danger error-text"></small>
                    </div>

                    <div class="form-group">
                        <div class="input-group input-group-password">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Password">
                            <button type="button" class="fas fa-eye toggle-password" toggle="#password"></button>
                        </div>
                        <small id="error-password" class="text-danger error-text"></small>
                    </div>

                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                <p class="mt-4 mb-0 text-center">
                    Belum punya akun? <a href="{{ url('register') }}">Daftar</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $("#form-login").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 5,
                        maxlength: 20
                    }
                },
                messages: {
                    username: {
                        required: "Username harus diisi.",
                        minlength: "Username minimal 4 karakter.",
                        maxlength: "Username maksimal 20 karakter."
                    },
                    password: {
                        required: "Password harus diisi.",
                        minlength: "Password minimal 5 karakter.",
                        maxlength: "Password maksimal 20 karakter."
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(() => window.location = response.redirect);
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorPlacement: function (error, element) {
                    var elementId = element.attr('id');
                    $('#error-' + elementId).text(error.text());
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });

        $(document).on('click', '.toggle-password', function (e) {
            e.preventDefault(); // Prevent any default button action
            let input = $($(this).attr("toggle"));
            let icon = $(this);

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });
    </script>
</body>

</html>