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
                                <li class="active"><a href="{{ url('student/profile') }}"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
                                <li><a href="{{ url('/student/course-lists') }}"><i class="fa fa-history" aria-hidden="true"></i> Courses</a></li>
                                <li><a href="javascript:void(0)" onclick="logout()"><i class="fa fa-sign-out"></i> Sign out</a></li>
                            </ul>
                        </div>
                        <!-- END OF Myaccount menu  -->
                    </div>
                    <!-- End of account cfoInfo -->
                </div>

                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

                    <div class="contact-details myaccount-contact">
                        <h2><i class="fa fa-lock"></i> Account access</h2>
                        <div class="account-table">
                            <p> Login Info</p>

                            <hr>

                            <p> {{ Auth::user()->email }} </p>
                            <p><a href="{{ url('student/change-password') }}">Modify my password</a></p>

                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <!-- END OF CONTACT DETAILS SECTION -->


                    <div class="contact-details myaccount-contact">
                        <h2><i class="fa fa-user"></i> Profile</h2>                         

                        <a href="{{ url('student/modify-address')}}" class="btn btn-primary pull-right"><i class="fa fa-edit"></i>&nbsp;Edit</a>                 
                        <p><strong>Name: {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong></p>
                        <p><strong>Email: {{ Auth::user()->email }}</strong></p>
                        <p><strong>Mobile No: {{ Auth::user()->mobile_no}}</strong></p>                
                        <p><strong>Joined At: {{ date("d-M-Y h:i:s", strtotime(Auth::user()->created_at)) }}</strong></p> 
							
                    </div>


                    <!-- END OF DELIVERY ADDRESS SECTION -->


                </div>

            </div>
        </div>
    </div>

    <style>
        @media (min-width: 1200px) .col-lg-3 {
            width: 25%;
        }

        @media (min-width: 1200px) .col-lg-6 {
            width: 50%;
        }
    </style>
@endsection
