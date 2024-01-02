@extends('layouts.frontend.layer')
@section('title', 'About Us | Drive Safe')
@section('content')
	@php $common_setting = getSettings(); @endphp
    <!-- breadcrumb start -->
    <div class="breadcrumb-area" style="background-image:url('{{ asset('assets/frontend/img/other/3.png') }}')">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="section-title mb-0">
                    <h2 class="page-title">About Us</h2>
                    <ul class="page-list">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>About Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- about area start -->
    <div class="about-area bg-relative pd-top-90 pd-bottom-120">
        <div class="container">
            <div class="about-area-inner">
                <div class="row">
                    <div class="col-lg-6 col-md-11">
                        <div class="about-thumb-wrap about-left-thumb">
                            <img class="img-1" src="{{ asset('assets/frontend/img/about/1.png') }}" alt="img">
                            <img class="img-3" src="{{ asset('assets/frontend/img/about/3.png') }}" alt="img">
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
                                    {{ $common_setting->mobile_no }}</h4>
                                <a class="btn btn-base btn-11" href="{{ url('/courses') }}">Start Course</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->

    <!-- counter area start -->
    <div class="counter-area bg-black pd-top-90 pd-bottom-90">
        <div class="counter-area-bg" style="background-image: url('{{ asset('assets/frontend/img/bg/1.png') }}')">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="media counter-list-inner">
                            <div class="media-left">
                                <div class="thumb">
                                    <img src="{{ asset('assets/frontend/img/icon/2.png') }}" alt="img">
                                </div>
                            </div>
                            <div class="media-body align-self-center">
                                <h2><span class="counter">5</span>K+</h2>
                                <p>Learn Driver</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="media counter-list-inner">
                            <div class="media-left">
                                <div class="thumb">
                                    <img src="{{ asset('assets/frontend/img/icon/3.png') }}" alt="img">
                                </div>
                            </div>
                            <div class="media-body align-self-center">
                                <h2><span class="counter">49</span>+</h2>
                                <p>Instructore</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="media counter-list-inner">
                            <div class="media-left">
                                <div class="thumb">
                                    <img src="{{ asset('assets/frontend/img/icon/4.png') }}" alt="img">
                                </div>
                            </div>
                            <div class="media-body align-self-center">
                                <h2><span class="counter">199</span>+</h2>
                                <p>Learning car</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="media counter-list-inner">
                            <div class="media-left">
                                <div class="thumb">
                                    <img src="{{ asset('assets/frontend/img/icon/5.png') }}" alt="img">
                                </div>
                            </div>
                            <div class="media-body align-self-center">
                                <h2><span class="counter">500</span>+</h2>
                                <p>heavy driving</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- counter area end -->

@endsection
