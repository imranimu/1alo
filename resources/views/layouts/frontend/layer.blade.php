<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <link rel=icon href="{{ asset('assets/frontend/img/favicon.png') }}" sizes="20x20" type="image/png">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    @yield('css')
    @yield('js')

    <script></script>
</head>
@php $common_setting = getSettings(); @endphp

<body>
    <!-- search popup start-->
    <div class="td-search-popup" id="td-search-popup">
        <form action="#" class="search-form">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search.....">
            </div>
            <button type="submit" class="submit-btn"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <!-- search popup end-->
    <div class="body-overlay" id="body-overlay"></div>

    <!--sidebar menu start-->
    <div class="sidebar-menu" id="sidebar-menu">
        <button class="sidebar-menu-close"><i class="fa fa-times"></i></button>
        <div class="sidebar-inner">
            <div class="thumb">
                <img src="{{ asset('assets/frontend/img/logo.png') }}" alt="logo" />
            </div>
            <p>If you wish to drive legally in the U.S, you must have a valid driver's license. A driver's license is a very important document that is usually about the same size as a credit card, a driver's license not only allows you to drive a motor vehicle legally on the road, it also acts as a photo identity card (ID) on many occasions.</p>

			<p>In order to obtain a driving license in the US, you will need to go through the licensing process. The procedures, like the documents you need to submit and tests you need to take, will differ from state to state but typical steps are usually the same.</p>
            <div class="sidebar-address">
                <h4 class="mb-3">Contact Us</h4>
                <ul>
                    <li><i class="fa fa-map-marker"></i>{{ $common_setting->address }}</li>
                    <li><i class="fa fa-envelope"></i>{{ $common_setting->email }}</li>
                    <li><i class="fa fa-phone"></i>{{ $common_setting->mobile_no }}</li>
                </ul>
            </div>
            <div class="sidebar-subscribe">
                <input type="text" placeholder="Email">
                <button><i class="fa fa-angle-right"></i></button>
            </div>
            <ul class="social-media">
                @if ($common_setting->facebook_link != '')
                    <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                @endif
                @if ($common_setting->twitter_link != '')
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                @endif
                @if ($common_setting->instagram_link != '')
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                @endif
                @if ($common_setting->pinterest_link != '')
                    <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                @endif
                @if ($common_setting->youtube_link != '')
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                @endif
                @if ($common_setting->linkedin_link != '')
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                @endif
            </ul>
        </div>
    </div>
    <!--sidebar menu end-->

    <!-- navbar start -->
    <div class="navbar-area">
        <!-- navbar top start -->
        <div class="navbar-top bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 text-md-left text-center">
                        <ul>
                            <li>
                                <p><i class="fa fa-map-marker"></i> {{ $common_setting->mobile_no }}</p>
                            </li>
                            <li>
                                <p><i class="fa fa-envelope-o"></i> {{ $common_setting->email }}</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="topbar-right text-md-right text-center">
                            <li class="social-area mr-1">
                                @if ($common_setting->facebook_link != '')
                                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                @endif
                                @if ($common_setting->twitter_link != '')
                                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                @endif
                                @if ($common_setting->instagram_link != '')
                                    <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                @endif
                                @if ($common_setting->pinterest_link != '')
                                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                @endif
                                @if ($common_setting->youtube_link != '')
                                    <a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                                @endif
                                @if ($common_setting->linkedin_link != '')
                                    <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                @endif
                            </li>
                            @if (Auth::check() && Auth::user()->is_role == 1)
                                <li class="mr-0">
                                    <a href="{{ url('admin/dashboard') }}">Admin</a>
                                </li>
                                <li class="mr-0">
                                    <a href="javascript:void(0)" onclick="logout()">{{ __('Logout') }}</a>
                                </li>
                            @elseif (Auth::check() && Auth::user()->is_role == 2)
                                <li class="mr-0">
                                    <a href="{{ url('student/dashboard') }}">My Account</a>
                                </li>
                                <li class="mr-0">
                                    <a href="javascript:void(0)" onclick="logout()">{{ __('Logout') }}</a>
                                </li>
                            @else
                                <li class="mr-0">
                                    <a href="{{ url('/login') }}"><i class="fa fa-user" aria-hidden="true"></i>
                                        Login</a>
                                </li>
                            @endif
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-area-1 navbar-area navbar-expand-lg">
            <div class="container nav-container">
                <div class="responsive-mobile-menu">
                    <button class="menu toggle-btn d-block d-lg-none" data-target="#edumint_main_menu"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-left"></span>
                        <span class="icon-right"></span>
                    </button>
                </div>
                <div class="logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('assets/frontend/img/logo.png') }}"
                            alt="img"></a>
                        <span style="
                            color: #fff;
                            font-size: 14px;
                            display: inline-block;
                            padding: 5px 15px;
                            border-radius: 7px;
                            margin-left: 10px;
                            background: #a70d13;
                        ">C 2759</span>
                </div>
                <div class="nav-right-part nav-right-part-mobile">
                    <a class="search-bar-btn" href="#"><i class="fa fa-search"></i></a>
                </div>
                <div class="collapse navbar-collapse" id="edumint_main_menu">
                    <ul class="navbar-nav menu-open text-right">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/about-us') }}">About Us</a></li>
                        <!--<li><a href="{{ url('/courses') }}">Courses</a></li>-->
						<li><a href="https://www.asiandrivingschool.us/lesson-price/" target="_blank">Courses</a></li>
                        <!--<li><a href="{{ url('/team') }}">Instructors</a></li> -->
                        <li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
                    </ul>
                </div>
                <div class="nav-right-part nav-right-part-desktop">
                    <a class="search-bar-btn" href="#"><i class="fa fa-search"></i></a>
                    <a class="btn btn-base menubar" id="navigation-button" href="#"><img
                            src="{{ url('assets/frontend/img/icon/12.png') }}" alt="img"></a>
                </div>
            </div>
        </nav>
    </div>
    <!-- navbar end -->

    @yield('content')

    <footer class="footer-area bg-overlay"
        style="background-image: url('{{ asset('assets/frontend/img/bg/3.png') }}');">
        <div class="container">
            <div class="subscribe-area-inner style-white pl-0 pr-0 pt-0">
                <div class="row">
                    <div class="col-xl-7 col-lg-6 align-self-center mb-4 mb-lg-0">
                        <h3>Subscribe to our newsletter</h3>
                        <p>Join Our Newsletter For Updates information Straight To Your Inbox.</p>
                    </div>
                    <div class="col-xl-5 col-lg-6 align-self-center">
                        <div class="single-subscribe-inner style-two">
                            <input type="text" placeholder="Enter Your E-mail">
                            <button class="btn btn-base">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widget widget_about pr-xl-4">
                        <div class="thumb">
                            <img src="{{ asset('assets/frontend/img/logo-2.png') }}" alt="img">
                        </div>
                        <div class="details">
                            <p>A driving school provides individuals with the knowledge and skills needed to obtain a driver's license and become a safe and responsible driver.</p>
                            <ul class="social-media">
                                <li>
                                    <a class="btn-base-m" href="#">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="btn-base-m" href="#">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="btn-base-m" href="#">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="btn-base-m" href="#">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="widget widget_nav_menu">
                        <h4 class="widget-title">Services</h4>
                        <ul>
                            <li><a href="{{ url('/courses') }}">Automatic Car</a></li>
                            <li><a href="{{ url('/courses') }}">Stick Shift Lessons</a></li>
                            <li><a href="{{ url('/courses') }}">Winter Driving</a></li>
                            <li><a href="{{ url('/courses') }}">Teen Driver</a></li>
                            <li><a href="{{ url('/courses') }}">Adult Car Lessons</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="widget widget_nav_menu">
                        <h4 class="widget-title">Quick LInks</h4>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/about-us') }}">About</a></li>
                            <li><a href="{{ url('/courses') }}">Course</a></li>
                            <li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
							<li><a href="{{ url('/faqs') }}">Faq's</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="widget widget_contact pl-lg-3">
                        <h4 class="widget-title">Contact Us</h4>
                        <ul class="details">
                            <li><i class="fa fa-phone"></i> {{ $common_setting->mobile_no }}</li>
                            <li><i class="fa fa-envelope"></i> {{ $common_setting->email }}</li>
                            <li><i class="fa fa-map-marker"></i> {{ $common_setting->address }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 align-self-center">
                        <p>Copyright © {{ date('Y') }} Drive Safe Driving School. All Right reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- back to top area start -->
    <div class="back-to-top">
        <span class="back-top"><i class="fa fa-angle-up"></i></span>
    </div>
    <!-- back to top area end -->


    <!-- all plugins here -->
    <script src="{{ asset('assets/frontend/js/vendor.js') }}"></script>

    <!-- main js  -->
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
    <script>
        function logout() {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }
    </script>
</body>

</html>
