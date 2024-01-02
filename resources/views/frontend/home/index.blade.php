@extends('layouts.frontend.layer')
@section('title', 'Home | Drive Safe')
@section('content')
    @php $common_setting = getSettings(); @endphp
    <!-- banner start -->
    <div class="banner-area banner-area-1"
        style="background-image: url({{ asset('assets/frontend/img/banner/slide02.jpg') }});">
        <div class="banner-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7 align-self-center">
                    <div class="banner-inner style-white text-center text-lg-left">
                        <img class="animate-img-1 top_image_bounce" src="{{ asset('assets/frontend/img/shape/3.png') }}"
                            alt="img">
                            
                        <h6 class="b-animate-1 sub-title">Welcome to</h6>
                        
                        <h1 class="b-animate-2 title">Drive Safe Driving School</h1>
                        
                        <p class="content b-animate-3">
                            * TDLR /TX DPS Approver course # PT 224 <br/>
                            * Get your permit right after 6 Hohurs <br/>
                            * Free Email or download Your certificate <br/>
                            * 100% Online PT Course Complete Your Own <br/>
                            * 100% Money Back Guarantee <br/>
                            * No Hidden Fees Free Read & Audio Along </p>
                            
                        <!--<h6 class="b-animate-1 sub-title">Driving School</h6>
                        <h1 class="b-animate-2 title">Developing your Driving Skills</h1>

                        <h3 style="
                            color: #fff;
                            font-size: 25px;
                            border: 1px solid;
                            display: inline-block;
                            padding: 5px 20px;
                            border-radius: 7px;
                            background: #a70d13;
                        ">C 2759</h3>

                        <p class="content b-animate-3">The driving test practice that will help you ace your exam. Your chances of passing the exam with these state-specific practice tests.</p> -->
                        <div class="btn-wrap">
                            <a class="btn btn-base btn-11 b-animate-4 mr-3" href="{{ url('contact-us') }}">Discover More</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-6 col-lg-7 align-self-center">
                    <img class="sliderRightImage" src="{{ asset('assets/frontend/img/allversion.png') }}" alt="">
                </div>
                
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- intro start -->
    <div class="intro-area intro-one-area mg-top--82">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single-intro-inner media">                         
                        <div class="details media-body text-center">
                            <h4>TX Parent taught driving ed + permit test</h4>

                            <hr>

                            <h2>$29.99</h2>

                            <ul>
                                <li>DPS permit test online</li>
                                <li>Get permit Affiliations someday</li>
                                <li>Download your certificate</li>
                                <li>100% online course</li>
                            </ul>     
                            
                            <a class="btn btn-base btn-11 b-animate-4" href="https://drivesafedrivingschool.com/courses/texas-parent-taught-drivers-ed">Start Today</a>

                        </div>
                    </div>
                </div>                
                <div class="col-lg-4 col-md-6">
                    <div class="single-intro-inner media">                         
                        <div class="details media-body text-center">
                            <h4>TX Instructor Thought Course + Permit Test</h4>

                            <hr>

                            <h2>$49.99</h2>

                            <ul>
                               
                            </ul>     
                            
                            <a class="btn btn-base btn-11 b-animate-4" href="javascript:void(0)">Coming Soon</a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-intro-inner media">                         
                        <div class="details media-body text-center">
                            <h4>TX Adult Driver Education with DPS Test</h4>

                            <hr>

                            <h2>$23.95</h2>

                            <ul>
                               
                            </ul>     
                            
                            <a class="btn btn-base btn-11 b-animate-4" href="javascript:void(0)">Coming Soon</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- intro end -->

    <!-- about area start -->
    <div class="about-area bg-relative pd-top-90 pd-bottom-120">
        <div class="container">
            <div class="about-area-inner">
                <div class="row">
                    <div class="col-lg-6 col-md-11">
                        <div class="about-thumb-wrap about-left-thumb">
                            <img class="img-1" src="{{ asset('assets/frontend/img/about/1.png') }}" alt="img">
                            <img class="img-2" src="{{ asset('assets/frontend/img/about/6.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="col-lg-6 align-self-center">
                        <div class="about-inner-wrap mt-2 pt-4 pt-lg-0">
                            <div class="section-title mb-0">
                                <h6 class="sub-title left-line">About Us</h6>
                                <h2 class="title">Best Driving company in the world</h2>
                                <p class="content">If you wish to drive legally in the U.S, you must have a valid driver's license. A driver's license is a very important document that is usually about the same size as a credit card, a driver's license not only allows you to drive a motor vehicle legally on the road, it also acts as a photo identity card (ID) on many occasions.</p>
								<br/>
								<p>In order to obtain a driving license in the US, you will need to go through the licensing process. The procedures, like the documents you need to submit and tests you need to take, will differ from state to state but typical steps are usually the same.</p>
                                <h4 class="small-title">We Can Help Develop For <br> Your Driving Skills</h4>
                                <h4 class="phone"><img src="{{ asset('assets/frontend/img/icon/1.png') }}" alt="img">
                                    {{ $common_setting->mobile_no }}
                                </h4>
                                <a class="btn btn-base btn-11" href="{{ url('courses') }}">Start Course</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->

    <!-- course area start -->
    <!--div class="course-area bg-light pd-top-115 pd-bottom-90 bg-relative">
        <div class="container">
            <div class="section-title">
                <div class="row">
                    <div class="col-xl-6 col-lg-7">
                        <h6 class="sub-title left-line">Tranding course</h6>
                        <h2 class="title">Course Upskill Your People With Driving Training</h2>
                    </div>
                    <div class="col-xl-6 col-lg-5 align-self-lg-end text-lg-right">
                        <div class="btn-wrap">
                            <a class="btn btn-base btn-11" href="{{ url('courses') }}">View Course</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-start">
                @if (!empty(getCourseLists()))
                    @foreach (getCourseLists() as $val)
                        <div class="col-lg-4 col-md-6">
                            <div class="single-course-inner">
                                <div class="thumb">
                                    @if ($val->image != '')
                                        <img src="{{ asset('storage/app/public/image/course/thumbnail/' . $val->image) }}"
                                            alt="img">
                                    @endif
                                    <div class="course-header-meta">
                                        <span class="price">{{ $val->price != '' ? '$' . $val->price : '' }}</span>
                                    </div>
                                </div>
                                <div class="details-inner">
                                    <div class="course-meta">
                                        <div class="row">
                                            <div class="col-6">
                                                <img src="{{ asset('assets/frontend/img/course/1.png') }}" alt="img">
                                                {{ $val->course_level }}
                                            </div>
                                            <div class="col-6 text-right">
                                                <img src="{{ asset('assets/frontend/img/course/2.png') }}" alt="img">
                                                {{ $val->course_duration != '' ? $val->course_duration . ' Week' : '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <h4><a href="{{ url('courses/' . $val->slug) }}">{{ $val->title }}</a></h4>
                                    @php
                                        $description = str_replace('<p>', '', substr($val->description, 0, 55));
                                    @endphp
                                    <p>{{ $description }}</p>
                                    <div class="course-footer">
                                        <div class="row">
                                            <div class="col-12 align-self-center text-right">
                                                <a class="read-more-text" href="{{ url('courses/' . $val->slug) }}">Read
                                                    More
                                                    <i class="la la-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div-->
    <!-- course area end -->

    <!-- about area start -->
    <div class="about-area pd-top-120 pd-bottom-120 bg-relative">
        <div class="container">
            <div class="about-area-inner">
                <div class="row">
                    <div class="col-lg-6 col-md-10 order-lg-12 text-lg-right">
                        <div class="about-thumb-wrap about-right-thumb">
                            <img class="img-1" src="{{ asset('assets/frontend/img/about/1.png') }}" alt="img">
                            <img class="img-2" src="{{ asset('assets/frontend/img/about/4.png') }}" alt="img">
                            <img class="img-3" src="{{ asset('assets/frontend/img/about/1.png') }}" alt="img">
                            <div class="about-quote">
                                <img src="{{ asset('assets/frontend/img/icon/8.png') }}" alt="img">
                                We’re trusted by more than 1100 clients
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1 align-self-center">
                        <div class="about-inner-wrap pt-4 pt-lg-0">
                            <div class="section-title mb-0">
                                <h6 class="sub-title left-line">Smart Way</h6>
                                <h2 class="title">Digital Tecnology For Much Easier Driving Learning</h2>
                                <div class="media single-list-inner mt-4">
                                    <div class="media-left mr-3">
                                        <img src="{{ asset('assets/frontend/img/icon/6.png') }}" alt="img">
                                    </div>
                                    <div class="media-body">
                                        <h4>Smartly Learn and safe</h4>
                                        <p class="mb-0">refers to learning in a way that is both effective and safe. It encompasses digital safety, safe physical environments, and mental health and well-being.</p>
                                    </div>
                                </div>
                                <div class="media single-list-inner mt-4">
                                    <div class="media-left mr-3">
                                        <img src="{{ asset('assets/frontend/img/icon/7.png') }}" alt="img">
                                    </div>
                                    <div class="media-body">
                                        <h4>Instructors Come to You</h4>
                                        <p class="mb-0">are individuals trained to administer driving exams and assess a candidate's driving abilities. They ensure new drivers have the necessary knowledge, skills, and experience to drive safely and responsibly. They work for the government or private driving schools and conduct both written and practical exams.</p>
                                    </div>
                                </div>
                                <a class="btn btn-base btn-11" href="course.html">Start Course</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->

    <!-- callto action area start -->
    <div class="call-to-action-area pd-top-110 pd-bottom-120 bg-overlay"
        style="background-image: url('{{ asset('assets/frontend/img/bg/2.png') }}');">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-8">
                    <div class="section-title style-white mb-0">
                        <h6 class="sub-title left-line">Help</h6>
                        <h2 class="title">We help our Students Pass the Driving Test on THEIR FIRST TRY</h2>
                        <p class="content">They cover every section of the driver's manual and literally "over-prepare" you, so the official exam will seem easy.</p>
                        <a class="btn btn-base btn-11" href="course.html">Start Course</a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4 align-self-center">
                    <div class="text-center pd-top-60 pt-lg-0">
                        <a class="video-play-btn" href="https://www.youtube.com/embed/Wimkqo8gDZ0"
                            data-effect="mfp-zoom-in"><i class="fa fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- callto action area end -->

    <!-- testimonial area start -->
    <div class="testimonial-area pd-top-120 pd-bottom-115" style="background-color: #F7FAFC;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-11">
                    <div class="section-title text-center">
                        <h6 class="sub-title double-line">Testimonial</h6>
                        <h2 class="title">What They Are Talking About Us</h2>
                    </div>
                </div>
            </div>
            <div class="testimonial-slider slider-control-dots owl-carousel">
                <div class="item">
                    <div class="single-testimonial-inner">
                        <img class="side-icon" src="{{ asset('assets/frontend/img/icon/9.png') }}" alt="img">
                        <p>I have gone through all the permit practice tests and passed the written test with ease in 15 min and 97% score. If you can go through these tests, there is no chance that you cannot clear the main written test.</p>
                        <div class="media">
                            <div class="media-body align-self-center">
                                <h6>Abigail Barbara</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-testimonial-inner">
                        <img class="side-icon" src="{{ asset('assets/frontend/img/icon/9.png') }}" alt="img">
                        <p>I took the test today and passed, I literally knew every single question on that test, I looked around thinking to myself, Are they serious?! lol, If you want to pass, these practice tests will help for sure!</p>
                        <div class="media">
                            <div class="media-body align-self-center">
                                <h6>Al Hshmud</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-testimonial-inner">
                        <img class="side-icon" src="{{ asset('assets/frontend/img/icon/9.png') }}" alt="img">
                        <p>Did my test yesterday and passed both the DMV test and driving test. Thank God for this site, I studied all the practice tests and that’s the reason I passed. This is better than a cheat sheet, time for my behind-the-wheel exam now!</p>
                        <div class="media">
                            <div class="media-body align-self-center">
                                <h6>Farguc Anti</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-testimonial-inner">
                        <img class="side-icon" src="{{ asset('assets/frontend/img/icon/9.png') }}" alt="img">
                        <p>This site definitely works. I practiced their questions for 24 hours. Went through each practice test then jumped into a bus to Santa Monica, California DMV. I passed the drivers test the first time; while the majority walked out with their faces down.</p>
                        <div class="media">
                            <div class="media-body align-self-center">
                                <h6>Wilson Jac</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonial area end -->
    
    <style>
        body .banner-inner .title{
            font-size: 33px;
        }
    </style>
@endsection
