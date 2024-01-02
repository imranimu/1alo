@extends('layouts.student.layer')
@section('title', 'Dashboard | Driving School')
@section('content')
    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="account-cfoinfo clearfix">
                        <div class="cfoaccount">
                            <ul class="list-unstyled">
                                <li><a href="{{ url('student/dashboard') }}"><i class="fa fa-home" aria-hidden="true"></i> My
                                        Account</a></li>
                                <li><a href="#"><i class="fa fa-history" aria-hidden="true"></i> Course History</a>
                                </li>
                                <li><a href="javascript:void(0)" onclick="logout()"><i class="fa fa-sign-out"></i> Sign
                                        out</a></li>
                            </ul>
                        </div>
                        <!-- END OF Myaccount menu  -->
                    </div>
                    <!-- End of account cfoInfo -->
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="contact-details myaccount-contact">
                        <h2>Account access</h2>
                        <div class="account-table">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td class="commonname-td">
                                            Sign in Info
                                        </td>
                                        <td class="nameshow-td">
                                            {{ Auth::user()->email }} </td>
                                    </tr>


                                    <tr>
                                        <td class="commonname-td">

                                        </td>
                                        <td class="nameshow-td">
                                            <a href="{{ url('student/change-password') }}">Modify my password</a>
                                        </td>

                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- END OF CONTACT DETAILS SECTION -->

                    <div class="contact-details myaccount-contact">
                        <h2>My Details <a href="{{ url('student/modify-address') }}">Modify address</a></h2>

                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                <div class="address-form">

                                    <div class="form-group">
                                        <p>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                        <p>{{ Auth::user()->mobile_no }}</p>
                                        <p>{{ Auth::user()->email }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- END OF DELIVERY ADDRESS SECTION -->


                </div>

            </div>
        </div>
    </div>
@endsection
