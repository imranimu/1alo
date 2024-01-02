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
                                <li><a href="{{ url('student/dashboard') }}"><i class="fa fa-home" aria-hidden="true"></i>
                                        Dashboard</a></li>
                                <li class="active"><a href="{{ url('student/profile') }}"><i class="fa fa-user"
                                            aria-hidden="true"></i> Profile</a></li>
                                <li><a href="{{ url('/student/course-lists') }}"><i class="fa fa-history"
                                            aria-hidden="true"></i> Courses</a></li>
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
                        <h2>Change Password</h2>
                        <div class="account-table">
                            <div class="modal-body">

                                <div id="logi">
                                    <!-- Message here -->
                                    @if (!empty(Session::get('message')) && Session::get('message')['status'] == '1')
                                        <div class="form-group row">
                                            <div class="alert alert-success inline">
                                                {{ Session::get('message')['text'] }}
                                            </div>
                                        </div>
                                    @elseif (!empty(Session::get('message')) && Session::get('message')['status'] == '0')
                                        <div class="form-group row">
                                            <div class="alert alert-danger inline">
                                                {{ Session::get('message')['text'] }}
                                            </div>
                                        </div>
                                    @endif
                                    <form action="{{ url($action_url) }}" method="post" class="form-group">
                                        @csrf
                                        <div class="form-group">
                                            <label>Current Password</label>
                                            <input type="password" class="form-control" name="current_Password"
                                                id="current_Password" placeholder="Current password"
                                                value="{{ isset(Session::get('message')['current_pass']) ? Session::get('message')['current_pass'] : old('current_Password') }}">
                                            @if ($errors->has('current_Password'))
                                                <strong>{{ $errors->first('current_Password') }}</strong>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" name="new_password"
                                                id="new_password" placeholder="New password"
                                                value="{{ isset(Session::get('message')['new_pass']) ? Session::get('message')['new_pass'] : old('new_password') }}">
                                            @if ($errors->has('new_password'))
                                                <strong>{{ $errors->first('new_password') }}</strong>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password"
                                                id="confirm_password" placeholder="Confirm password"
                                                value="{{ isset(Session::get('message')['confirm_pass']) ? Session::get('message')['confirm_pass'] : old('confirm_password') }}">
                                            @if ($errors->has('confirm_password'))
                                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="submit" id="submit"
                                                class="btn btn-primary btn-block custom-checkout" value="Change password">
                                        </div>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>

            </div>
        </div>
    </div>
@endsection
