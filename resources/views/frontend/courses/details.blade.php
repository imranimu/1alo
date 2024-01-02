@extends('layouts.frontend.layer')
@section('title', 'Courses Details | Drive Safe')
@section('content')
    @php $common_setting = getSettings() @endphp
    <!-- breadcrumb start -->
    <div class="breadcrumb-area" style="background-image:url('{{ asset('assets/frontend/img/other/3.png') }}')">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="section-title mb-0">
                    <h2 class="page-title">Course Single</h2>
                    <ul class="page-list">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Course Single</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- course-single area start -->
    <div class="course-single-area pd-top-120 pd-bottom-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="thumb">
                        @if ($getCourse->image != '')
                            <img src="{{ asset('storage/app/public/image/course/' . $getCourse->image) }}" alt="img">
                        @endif
                    </div>
                    <div class="course-course-details-inner">
                        <div class="course-details-nav-tab text-center">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1"
                                        role="tab" aria-controls="tab1" aria-selected="true"><i class="fa fa-book"></i>
                                        Overview</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab"
                                        aria-controls="tab2" aria-selected="false">
                                        <i class="fa fa-file-text-o"></i> Discussions</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                aria-labelledby="tab1-tab">
                                <div class="course-details-content">
                                    <h4 class="title">{{ $getCourse->title }}</h4>

                                    <h2 class="zoom-in-zoom-out">
                                        {{ $getCourse->price != '' ? '$' . $getCourse->price : '' }}
                                    </h2>

                                    {!! $getCourse->description !!}

                                    @if ($getPurchaseStatus > 0)
                                        <a href="{{ url('student/course-lists') }}"
                                            class="btn btn-base btn-11 btn-11 w-100">Course Open</a>
                                    @else
                                        <a href="{{ url('courses/purchase') }}" class="btn btn-base btn-11 btn-11 w-100">Get
                                            Started</a>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                <div class="course-details-content">
                                    {!! $getCourse->discussions !!}
                                    @if ($getPurchaseStatus > 0)
                                        <a href="{{ url('student/course-lists') }}" class="btn btn-base btn-11">Course Open</a>
                                    @else
                                        <a href="{{ url('courses/purchase') }}" class="btn btn-base btn-11">Get
                                            Started</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="related-course">
                        <div class="row justify-content-start pd-top-100">
                            <div class="col-12">
                                <h4 class="pb-3">Related Courses</h4>
                            </div>
                            @if (count(getRandomCourseLists($getCourse->id)) > 0)
                                @foreach (getRandomCourseLists($getCourse->id) as $val)
                                    <div class="col-md-6">
                                        <div class="single-course-inner">
                                            <div class="thumb">
                                                @if ($val->image != '')
                                                    <img src="{{ asset('storage/app/public/image/course/thumbnail/' . $val->image) }}"
                                                        alt="img">
                                                @endif
                                                <div class="course-header-meta">
                                                    <span
                                                        class="price">{{ $val->price != '' ? '$' . $val->price : '' }}</span>
                                                </div>
                                            </div>
                                            <div class="details-inner">
                                                <div class="course-meta">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <img src="{{ asset('assets/frontend/img/course/1.png') }}"
                                                                alt="img">
                                                            {{ $val->price }}
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <img src="{{ asset('assets/frontend/img/course/2.png') }}"
                                                                alt="img">
                                                            {{ $val->course_duration != '' ? $val->course_duration . ' Week' : '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4><a href="{{ url('courses/' . $val->slug) }}">{{ $val->title }}</a>
                                                </h4>
                                                @php
                                                    $description = $val->description != '' ? str_replace('<p>', '', substr($val->description, 0, 55)) : '';
                                                @endphp
                                                <p>{{ $description }}</p>
                                                <div class="course-footer">
                                                    <div class="row">
                                                        <div class="col-12 align-self-center text-right">
                                                            <a class="read-more-text"
                                                                href="{{ url('courses/' . $val->slug) }}">Read
                                                                More <i class="la la-arrow-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No Related courses found!</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="td-sidebar">
                        <div class="widget widget_catagory">
                            <h4 class="widget-title">Catagory</h4>
                            <ul class="catagory-items">
                                <li><a href="{{ url('/courses') }}"><img
                                            src="{{ asset('assets/frontend/img/icon/16.png') }}" alt="img">Automatic
                                        Car</a></li>
                                <li><a href="{{ url('/courses') }}"><img
                                            src="{{ asset('assets/frontend/img/icon/16.png') }}" alt="img">Stick
                                        Shift
                                        Lesson</a></li>
                                <li><a href="{{ url('/courses') }}"><img
                                            src="{{ asset('assets/frontend/img/icon/16.png') }}" alt="img">Winter
                                        Driving</a></li>
                                <li><a href="{{ url('/courses') }}"><img
                                            src="{{ asset('assets/frontend/img/icon/16.png') }}" alt="img">Adult Car
                                        Lessons</a></li>
                                <li><a href="{{ url('/courses') }}"><img
                                            src="{{ asset('assets/frontend/img/icon/16.png') }}" alt="img">Driver
                                        Education</a></li>
                                <li><a href="{{ url('/courses') }}"><img
                                            src="{{ asset('assets/frontend/img/icon/16.png') }}" alt="img">Program
                                        for
                                        Seniors</a></li>
                            </ul>
                        </div>
                        <div class="widget widget_contact">
                            <h4 class="widget-title">Contact Us</h4>
                            <ul class="details">
                                <li><i class="fa fa-phone"></i> {{ $common_setting->mobile_no }}</li>
                                <li><i class="fa fa-envelope"></i> {{ $common_setting->email }}</li>
                                <li><i class="fa fa-map-marker"></i> {{ $common_setting->address }}</li>
                            </ul>
                            <ul class="social-media pt-2">
                                @if ($common_setting->facebook_link != '')
                                    <li>
                                        <a class="btn-base-m" href="#">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($common_setting->twitter_link != '')
                                    <li>
                                        <a class="btn-base-m" href="#">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($common_setting->instagram_link != '')
                                    <li>
                                        <a class="btn-base-m" href="#">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($common_setting->linkedin_link != '')
                                    <li>
                                        <a class="btn-base-m" href="#">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($common_setting->youtube_link != '')
                                    <li>
                                        <a class="btn-base-m" href="#">
                                            <i class="fa fa-youtube"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($common_setting->pinterest_link != '')
                                    <li>
                                        <a class="btn-base-m" href="#">
                                            <i class="fa fa-pinterest"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- course-single area end -->

@endsection
