<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="Driving Safe School Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('assets/admin/images/favicon.ico') }}">

    <!-- jsvectormap css -->
    <link href="{{ url('assets/admin/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ url('assets/admin/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ url('assets/admin/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ url('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ url('assets/admin/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css"href="{{ url('assets/admin/css/toastr.min.css') }}">

    <script src="{{ url('assets/admin/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ url('assets/admin/js/toastr.min.js') }}"></script>
    <script src="{{ url('assets/admin/js/bootstrap.min.js') }}"></script>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <!-- <div class="navbar-brand-box horizontal-logo">
                            <a href="index-2.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </span>
                            </a>

                            <a href="index-2.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="17">
                                </span>
                            </a>
                        </div>

                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button> -->


                    </div>

                    <div class="d-flex align-items-center">

                        <!-- <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div> -->

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    @if (Auth::user()->image != '')
                                        <img class="rounded-circle header-profile-user"
                                            src="{{ asset('storage/app/public/image/avatars/thumbnail/' . Auth::user()->image) }}"
                                            alt="Header Avatar">
                                    @else
                                        <img class="rounded-circle header-profile-user"
                                            src="{{ url('assets/admin/avatars/thum_no_image.jpg') }}"
                                            alt="Header Avatar">
                                    @endif
                                    <span class="text-start ms-xl-2">
                                        <span
                                            class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ ucwords(Auth::user()->first_name . ' ' . Auth::user()->last_name) }}</span>
                                        <span
                                            class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Admin</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="{{ url('admin/profile') }}"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">Profile</span></a>
                                <a class="dropdown-item" href="{{ url('admin/change-password') }}"><i
                                        class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle">Change Password</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascipt:void(0)" onclick="logout()"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
               
                <!-- <a href="index-2.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="17">
                    </span>
                </a> 
                <a href="index-2.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button> -->
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('admin/dashboard') }}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Dashboard</span>
                            </a>
                        </li>
                        <!-- end Dashboard Menu -->

                        <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Courses</span>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#coursesPages" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="coursesPages">
                                <i class="ri-pages-line"></i> <span data-key="t-pages">Courses</span>
                            </a>
                            <div class="collapse menu-dropdown" id="coursesPages">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('admin/course/course-lists') }}" class="nav-link"
                                            data-key="t-starter"> All Courses
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/course/course-createe') }}" class="nav-link"
                                            data-key="t-team"> Add New </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('admin/course/course-preview') }}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Course Preview</span>
                            </a>
                        </li>

                        <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Exam. &
                                Document</span></li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('admin/question/exam-show') }}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Manage Exams</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('admin/document/show') }}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Documents Upload</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('admin/license/add-license') }}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">License Number</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('admin/certificate') }}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Certificate lists</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('admin/payment/show') }}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Payment List</span>
                            </a>
                        </li>

                        <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">User</span>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#userPages" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="userPages">
                                <i class="ri-pages-line"></i> <span data-key="t-pages">User List</span>
                            </a>
                            <div class="collapse menu-dropdown" id="userPages">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('admin/student-show') }}" class="nav-link"
                                            data-key="t-starter"> Student
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/admin-show') }}" class="nav-link" data-key="t-team">
                                            Admin </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/report') }}" class="nav-link" data-key="t-team">
                                            Student Acitvity Report </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-title"><i class="ri-more-fill"></i> <span
                                data-key="t-components">Settings</span>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#settingPages" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="settingPages">
                                <i class="ri-pages-line"></i> <span data-key="t-pages">Setting</span>
                            </a>
                            <div class="collapse menu-dropdown" id="settingPages">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('admin/addon/add-addon') }}" class="nav-link"
                                            data-key="t-starter"> Payment Addon
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/setting') }}" class="nav-link" data-key="t-team">
                                            Site Setting </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/security/add-question') }}" class="nav-link"
                                            data-key="t-team">
                                            Add Security Question </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/guide/show') }}" class="nav-link" data-key="t-team">
                                            Add Guidelines </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-title"><i class="ri-more-fill"></i> <span
                                data-key="t-components">Logout</span>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="javascript:void(0)" onclick="logout()">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Logout</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © A Auto Driving School.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Kawser
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ url('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    {{-- <script src="{{ url('assets/admin/libs/node-waves/waves.min.js') }}"></script> --}}
    {{-- <script src="{{ url('assets/admin/libs/feather-icons/feather.min.js') }}"></script> --}}
    <script src="{{ url('assets/admin/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    {{-- <script src="{{ url('assets/admin/js/plugins.js') }}"></script> --}}

    <!-- apexcharts -->
    {{-- <script src="{{ url('assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script> --}}



    <!-- App js -->
    {{-- <script src="{{ url('assets/admin/js/app.js') }}"></script> --}}

    <script>
        function logout() {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }
    </script>

    <style>
        img, svg{
            max-width: 100%;
        }
        button.bootbox-close-button.close {
            float: right;
            border: none;
            background: none;
        }
        body .table-nowrap td, body .table-nowrap th {
            white-space: normal;
        }
        .control-group{
            margin-bottom: 15px;
        }
        .live-preview{
            /*height: calc(100vh - 330px);*/
            height: 612px;
            overflow: auto;
        }
    </style>
</body>

</html>
