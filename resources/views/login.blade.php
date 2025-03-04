<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jay Stud Farm - Login</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">

    <link rel="stylesheet" href="{{url('public/plugins/fontawesome-free/css/all.min.css')}}">

    <link rel="stylesheet" href="{{url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{url('public/dist/css/adminlte.min2167.css?v=3.2.0')}}">
    <link rel="stylesheet" href="{{url('public/dist/css/style.css')}}">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.8/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.8/dist/sweetalert2.min.js"></script>

</head>

<body class="hold-transition login-page">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{url('public/dist/img/horse-riding.gif')}}" alt="JSF loader" height="130">
    </div>

    <div class="login-box">

        <div class="card border-top-cream">
            <div class="card-header text-center bg-brown py-2">
                <a href="{{url('')}}" class="h1"><img src="public/dist/img/logo.webp" width="120" alt="Logo"></a>
            </div>
            <div class="card-body">
                <h1 class="text-center"><b>JSF </b>Dashboard</h1>
                <form action="" method="post" id="login">
                    <p class="success_msg success"></p>
                    <p class="error_msg error"></p>
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <input type="text" name="username" class="form-control" placeholder="Username">
                        </div>
                        <div class="username_err error"></div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="password_err error"></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-brown btn-block">Sign In</button>
                        </div>

                    </div>
                </form>
            </div>

        </div>

    </div>


    <script src="public/plugins/jquery/jquery.min.js"></script>
    <script src="public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/dist/js/adminlte.min2167.js?v=3.2.0"></script>
    <script>
        $(document).ready(function () {
            $("#login").submit(function (e) {
                e.preventDefault();
                var form = $("#login")[0];
                var data = new FormData(form);
                var loader = $('.preloader');
                var loaderIMG = $('.preloader img');
                loader.height("100vh");
                loaderIMG.show()
                $("#submitBtn").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{Route('VerifyLogin')}}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        loader.height("0vh");
                        loaderIMG.hide()
                        //alert(data.status);
                        //console.log(data)

                        if (data.status == 'success') {
                            Swal.fire({
                                icon: data.status,
                                title: data.message
                            }).then(() => {
                                window.location.href = "{{Route('home')}}"
                            })
                        } else {
                            $('.error').html('')
                            $(".success_msg").html('');
                            $(".error_msg").html(data.message);
                            printError(data.error)
                        }
                        $("#submitBtn").prop("disabled", false);
                    },
                    error: function (error) {
                        console.log(error.responseJSON);
                        $("#submitBtn").prop("disabled", false);
                    }
                })
            })
        })



        function printError(err) {
            $.each(err, function (key, value) {
                $("." + key + "_err").text(value)
            })
        }
    </script>

</body>

</html>