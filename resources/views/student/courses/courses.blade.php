@extends('layouts.student.layer')
@section('title', 'Dashboard | Driving School')
@section('content')

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="account-cfoinfo">
                        <div class="cfoaccount">
                            <ul class="list-unstyled">
                                <li><a href="{{ url('student/dashboard') }}"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                                <li><a href="{{ url('student/profile') }}"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
                                <li class="active"><a href="{{ url('student/course-lists') }}"><i class="fa fa-history" aria-hidden="true"></i> Courses</a></li>
                                <li><a href="javascript:void(0)" onclick="logout()"><i class="fa fa-sign-out"></i> Sign Out</a></li>
                            </ul>
                        </div>
                        <!-- END OF Myaccount menu  -->
                    </div>
                    <!-- End of account cfoInfo -->
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 text-center">
                    <div class="wrap">
   
                        <div class="row home-grids justify-content-center">
                            <div class="col-md-3">
                                <a href="{{ url('student/course-lists') }}">
                                    <div class="home-grid bg-info">
                                        <i class="fa fa-book"></i>
                                        <h6>Goto Course</h6>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="#">
                                    <div class="home-grid bg-success">
                                        <i class="fa fa-refresh"></i>
                                        <h6>Course Summary</h6>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <!-- END OF CONTACT DETAILS SECTION -->

                </div>

            </div>
        </div>
    </div>
@endsection
