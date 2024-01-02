@extends('layouts.frontend.layer')
@section('title', 'Contact Us | Drive Safe')
@section('content')
	@php $common_setting = getSettings(); @endphp
    <!-- breadcrumb start -->
    <div class="breadcrumb-area" style="background-image:url('{{ asset('assets/frontend/img/other/3.png') }}')">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="section-title mb-0">
                    <h2 class="page-title">Contact Us</h2>
                    <ul class="page-list">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <div class="contact-area pd-top-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="media single-contact-info">
                        <div class="media-left thumb">
                            <img src="{{ asset('assets/frontend/img/icon/13.png') }}" alt="img">
                        </div>
                        <div class="media-body details">
                            <h4>Call Us</h4>
                            <p>{{ $common_setting->mobile_no }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="media single-contact-info">
                        <div class="media-left thumb">
                            <img src="{{ asset('assets/frontend/img/icon/14.png') }}" alt="img">
                        </div>
                        <div class="media-body details">
                            <h4>Mail Drop Us</h4>
                            <p>{{ $common_setting->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="media single-contact-info">
                        <div class="media-left thumb">
                            <img src="{{ asset('assets/frontend/img/icon/15.png') }}" alt="img">
                        </div>
                        <div class="media-body details">
                            <h4>Location</h4>
                            <p>{{ $common_setting->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- contact form area start -->
    <div class="contact-form-area pd-top-120 pd-bottom-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-form-inner">
                        <div class="section-title mb-0">
                            <h6 class="sub-title left-line">Get In touch</h6>
                            <h3 class="small-title mt-0">We are always ready to solution <br> your any problem</h3>
                        </div>
                        <form class="mt-5 mt-md-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="single-input-inner">
                                        <input type="text" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single-input-inner">
                                        <input type="text" placeholder="Email">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="single-input-inner">
                                        <input type="text" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="single-input-inner">
                                        <textarea placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-base btn-11">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="contact-g-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3351.2079171189034!2d-96.97839198499668!3d32.86621788094518!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x864e8268ea932ba7%3A0x84847aaa5958a3a1!2s2214%20W%20Walnut%20Hill%20Ln%2C%20Irving%2C%20TX%2075038%2C%20USA!5e0!3m2!1sen!2sbd!4v1676054534768!5m2!1sen!2sbd"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact form area end -->

@endsection
