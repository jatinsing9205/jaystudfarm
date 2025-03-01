<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jay Stud Farm - Marwari Horses</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
        href="{{url('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{url('public/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('public/plugins/summernote/summernote-bs4.min.css')}}">
    <link rel="stylesheet" href="{{url('public/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('public/dist/css/adminlte.min2167.css?v=3.2.0')}}">
    <link rel="stylesheet" href="{{url('public/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('public/dist/css/dataTables.css')}}">
    <link rel="stylesheet" href="{{url('public/dist/css/responsive.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('public/dist/css/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{url('public/dist/css/lightslider.css')}}">
    <link rel="stylesheet" href="{{url('public/dist/css/style.css')}}">

    <script src="{{url('public/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{url('public/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.8/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.8/dist/sweetalert2.min.js"></script>


</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed sidebar-collapse layout-footer-fixed"
    cz-shortcut-listen="true" style="height: auto;">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
            <img class="animation__shake" src="{{url('public/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo"
                height="60" width="60" style="display: none;">
        </div>

        <nav class="main-header navbar navbar-expand navbar-white navbar-dark bg-indigo">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{url('/')}}" class="nav-link">Home</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-light" href="{{url('logout')}}" role="button">
                        <i class="fas fa-lock mr-2 text-danger"></i> <span class="text-danger fw-bold"> LOGOUT</span>
                    </a>
                </li>
            </ul>
        </nav>


        <aside class="main-sidebar elevation-4 sidebar-light-indigo">
            <a href="index.php" class="brand-link bg-indigo">
                <img src="{{url('public/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Jay Stud Farm</span>
            </a>

            <div class="sidebar bg-light">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{url('public/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Siddharth Gupta</a>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent"
                        data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <!-- <i class="right fas fa-angle-left"></i> -->
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="our-horses.php" class="nav-link">
                                <i class="nav-icon fas fa-horse"></i>
                                <p>
                                    Our Horses
                                    <span class="right badge badge-danger">Explore</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="horse-report.php" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Horse Report
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </aside>







        <div class="content-wrapper">
            @yield("content")
        </div>



        <footer class="main-footer">
            <strong>Copyright ©
                <script type="text/javascript">var year = new Date(); document.write(year.getFullYear());</script>
                <a href="#">Jay Stud Farm</a>.
            </strong>
            All rights reserved.
        </footer>

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>



    <script>$.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{url('public/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('public/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{url('public/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('public/dist/js/adminlte2167.js?v=3.2.0')}}"></script>
    <script src="{{url('public/dist/js/dataTables.js')}}"></script>
    <script src="{{url('public/dist/js/dataTables.responsive.js')}}"></script>
    <script src="{{url('public/dist/js/jquery.fancybox.min.js')}}"></script>
    <script src="{{url('public/dist/js/lightslider.js')}}"></script>
    <script src="{{url('public/dist/js/demo.js')}}"></script>
    <script src="{{url('public/dist/js/custom.js')}}"></script>
    <script>
        new DataTable('.dataTable', {
            responsive: true
        });
    </script>
</body>

</html>