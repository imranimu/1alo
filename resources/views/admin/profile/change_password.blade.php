@extends('layouts.admin.layer')
@section('title', 'Change Passwrod | Manchester School')
@section('content')
<style type="text/css">
    .back-our-work-page {
        margin-bottom: 10px;
    }
</style>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">Home</a>
            <span class="divider">
                <i class="icon-angle-right arrow-icon"></i>
            </span>
        </li>
        <li class="active">Change Password</li>
    </ul>
    <!--.breadcrumb-->
</div>

<div class="page-content">
    <div class="page-header position-relative">
        <h1>Change Password</h1>
    </div>
    <!--/.page-header-->
    <div class="row-fluid">
        <div class="span12">

            <!-- Message here -->
            @if (!empty(Session::get('message')) && Session::get('message')['status'] == '1')
            <div class="control-group">
                <div class="alert alert-success inline">
                    {{ Session::get('message')['text'] }}
                </div>
            </div>
            @elseif (!empty(Session::get('message')) && Session::get('message')['status'] == '0')
            <div class="control-group">
                <div class="alert alert-danger inline">
                    {{ Session::get('message')['text'] }}
                </div>
            </div>
            @endif

            <!--PAGE CONTENT BEGINS-->
            <form action="{{ url($action_url) }}" method="post" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8">
                @csrf
                {{ method_field('PUT') }}
                <div class="control-group">
                    <label class="control-label" for="form-field-2">Current Password</label>
                    <div class="controls">
                        <input type="password" placeholder="Current Password" name="current_Password" id="current_Password" value="{{ isset(Session::get('message')['current_pass']) ? Session::get('message')['current_pass'] : old('current_Password') }}">
                        @if ($errors->has('current_Password'))
                            <strong>{{ $errors->first('current_Password') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-2">New Password</label>
                    <div class="controls">
                        <input type="password" placeholder="New Password" name="new_password" id="new_password" value="{{ isset(Session::get('message')['new_pass']) ? Session::get('message')['new_pass'] : old('new_password') }}">
                        @if ($errors->has('new_password'))
                            <strong>{{ $errors->first('new_password') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-2">Confirm Password</label>
                    <div class="controls">
                        <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password" value="{{ isset(Session::get('message')['confirm_pass']) ? Session::get('message')['confirm_pass'] : old('confirm_password') }}">
                        @if ($errors->has('confirm_password'))
                            <strong>{{ $errors->first('confirm_password') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-2">&nbsp;</label>
                    <div class="controls">
                        <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Change Password">
                    </div>
                </div>

            </form>

        </div>
        <!--PAGE CONTENT ENDS-->
    </div>
    <!--/.span-->

</div>
<!--/.row-fluid-->
@endsection
