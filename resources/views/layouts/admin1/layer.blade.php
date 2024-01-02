<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--basic styles-->
    <link href="{{ url('assets/admin/css/style.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/admin/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="{{ url('assets/admin/css/font-awesome.min.css') }}" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--[if IE 7]>
      <link rel="stylesheet" href="{{ url('assets/admin/css/font-awesome-ie7.min.css') }}" />
    <![endif]-->

    <!--page specific plugin styles-->
    <!--fonts-->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

    <!--ace styles-->
    <link rel="stylesheet" href="{{ url('assets/admin/css/ace.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/css/ace-responsive.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/admin/css/ace-skins.min.css') }}" />
    <link rel="stylesheet" type="text/css"href="{{ url('assets/admin/css/toastr.min.css') }}">
    <script src="{{ url('assets/admin/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ url('assets/admin/js/toastr.min.js') }}"></script>
	
	<script src="{{ url('assets/admin/js/bootstrap.min.js') }}"></script>

    <!--[if lte IE 8]>
      <link rel="stylesheet" href="{{ url('assets/admin/css/ace-ie.min.css') }}" />
    <![endif]-->

    <!--inline styles related to this page-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<style>
        body #questionModal.modal {
            display: none;
        }
		
		body .table th, body .table td{
			vertical-align: middle;
		}

        #chooseBook{
            display: none;
        }
		
		body .modal-header .close {
			margin-top: -28px;
		}
    </style>
</head>

<body>
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a href="{{ url('/') }}" class="brand">
                    <small>
                        <i class="icon-leaf"></i>
                        Driver Safe Driving School
                    </small>
                </a>
                <!--/.brand-->

                <ul class="nav ace-nav pull-right">

                    <li class="light-blue">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            @if (Auth::user()->image != '')
                                <img class="nav-user-photo"
                                    src="{{ asset('storage/app/public/image/avatars/thumbnail/' . Auth::user()->image) }}"
                                    alt="User image dropdown" />
                            @else
                                <img class="nav-user-photo" src="{{ url('assets/admin/avatars/thum_no_image.jpg') }}"
                                    alt="User image dropdown" />
                            @endif

                            <span class="user-info">
                                <small>Welcome,</small>
                                {{ ucwords(Auth::user()->first_name . ' ' . Auth::user()->last_name) }}
                            </span>

                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                            <li>
                                <a href="{{ url('admin/profile') }}">
                                    <i class="fa fa-user"></i>
                                    Profile
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('admin/change-password') }}">
                                    <i class="fa fa-key"></i>
                                    Change Password
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="javascipt:void(0)" onclick="logout()">
                                    <i class="fa fa-off"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!--/.ace-nav-->
            </div>
            <!--/.container-fluid-->
        </div>
        <!--/.navbar-inner-->
    </div>

    <div class="main-container container-fluid">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <div class="sidebar" id="sidebar">
            <ul class="nav nav-list">
                <li class="active">
                    <a href="{{ url('admin/dashboard') }}">
                        <i class="fa fa-dashboard"></i>
                        <span class="menu-text"> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-list"></i>
                        <span class="menu-text"> Courses </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <ul class="submenu">
						<li>
                            <a href="{{ url('admin/course/course-lists') }}">
                                <i class="fa fa-double-angle-right"></i>
                                All Courses
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/course/course-createe') }}">
                                <i class="fa fa-double-angle-right"></i>
                                Add New
                            </a>
                        </li>
						<!--li>
                            <a href="{{ url('admin/course/course-preview') }}">
                                <i class="fa fa-double-angle-right"></i>
                                Preview
                            </a>
                        </li-->
                    </ul>
                </li>

                <li>
                    <a href="{{ url('admin/course/course-preview') }}">
                        <i class="fa fa-eye"></i>
                        <span class="menu-text">Course Preview </span>
                    </a>
                </li>
				
				<li>
                    <a href="{{ url('admin/question/exam-show') }}">
                        <i class="fa fa-question-circle"></i>
                        <span class="menu-text"> Manage Exams </span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('admin/document/show') }}">
                        <i class="fa fa-file"></i>
                        <span class="menu-text"> Documents Upload </span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('admin/license/add-license') }}">
                        <i class="fa fa-id-card"></i>
                        <span class="menu-text"> License Number </span>
                    </a>
                </li>
				
				<li>
                    <a href="{{ url('admin/certificate') }}">
                        <i class="fa fa-id-card"></i>
                        <span class="menu-text"> Certificate lists</span>
                    </a>
                </li>
				
				<li>
                    <a href="{{ url('admin/payment/show') }}">
                        <i class="fa fa-credit-card"></i>
                        <span class="menu-text"> Payment List </span>
                    </a>
                </li>
				
				<li>
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-users"></i>
                        <span class="menu-text"> User List </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="{{ url('admin/student-show') }}">
                                <i class="fa fa-double-angle-right"></i>
                                Student
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('admin/admin-show') }}">
                                <i class="fa fa-double-angle-right"></i>
                                Admin
                            </a>
                        </li>
						<li>
                            <a href="{{ url('admin/report') }}">
                                <i class="fa fa-double-angle-right"></i>
                                Report
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-cogs"></i>
                        <span class="menu-text"> Setting </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="{{ url('admin/addon/add-addon') }}">
                                <i class="fa fa-double-angle-right"></i>
                                Payment Addon
                            </a>
                        </li>
						
						<!--li>
                            <a href="{{ url('admin/license/add-license') }}">
                                <i class="fa fa-double-angle-right"></i>
                                License Number
                            </a>
                        </li-->

                        <li>
                            <a href="{{ url('admin/setting') }}">
                                <i class="fa fa-double-angle-right"></i>
                                Site Setting
                            </a>
                        </li>
						
						<li>
                            <a href="{{ url('admin/security/add-question') }}">
                                <i class="fa fa-double-angle-right"></i>
                                Add Security Question
                            </a>
                        </li>
						
						<li>
                            <a href="{{ url('admin/guide/show') }}">
                                <i class="fa fa-double-angle-right"></i>
                                Add Guidelines
                            </a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0)" onclick="logout()">
                        <i class="fa fa-off"></i>
                        <span class="menu-text"> Logout </span>
                    </a>
                </li>
            </ul>
            <!--/.nav-list-->

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="fa fa-double-angle-left"></i>
            </div>
        </div>

        <div class="main-content">
            @yield('content')
        </div>
        <!--/.main-content-->
    </div>
    <!--/.main-container-->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>


    <!--[if !IE]>-->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>-->
    <!--<![endif]-->

    <!--[if IE]>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <![endif]-->

    <!--[if !IE]>-->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='{{ url('assets/admin/js/jquery-2.0.3.min.js') }}'>" + "<" +
            "/script>");
    </script>
    <!--<![endif]-->

    <!--[if IE]>
        <script type="text/javascript">
            window.jQuery || document.write("<script src='{{ url('assets/admin/js/jquery-1.10.2.min.js') }}'>" + "<" +
                "/script>");
        </script>
    <![endif]-->

    <script type="text/javascript">
        if ("ontouchend" in document) document.write(
            "<script src='{{ url('assets/admin/js/jquery.mobile.custom.min.js') }}'>" + "<" + "/script>");
    </script>


    <!--ace scripts-->
    <script src="{{ url('assets/admin/js/ace-elements.min.js') }}"></script>
    <script src="{{ url('assets/admin/js/ace.min.js') }}"></script>

    <script>
        function logout() {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }
    </script>
    <style>
        .badge-danger {
            background: red !important;
        }
    </style>
</body>

</html>
