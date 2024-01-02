@extends('layouts.admin.layer')
@section('title', 'Change Passwrod | Driving School')
@section('content')
    <style type="text/css">
        .back-our-work-page {
            margin-bottom: 10px;
        }
    </style>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        @if ($is_type == 1)
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin/student-lists') }}">Student Lists</a>
                            </li>
                        @else
                            <li class="breadcrumb-itme">
                                <a href="{{ url('admin/employee-lists') }}">Employee Lists</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Change Password</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="control-group">
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
                    </div>

                    <!--PAGE CONTENT BEGINS-->
                    <form action="{{ url($action_url) }}" method="post" class="form-horizontal"
                        enctype="multipart/form-data" accept-charset="utf-8">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">New Password</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="password" placeholder="New Password" class="form-control" name="new_password"
                                    id="new_password"
                                    value="{{ isset(Session::get('message')['new_pass']) ? Session::get('message')['new_pass'] : old('new_password') }}">
                                @if ($errors->has('new_password'))
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="last_name" class="form-label">Confirm Password</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="password" placeholder="Confirm Password" class="form-control"
                                    name="confirm_password" id="confirm_password"
                                    value="{{ isset(Session::get('message')['confirm_pass']) ? Session::get('message')['confirm_pass'] : old('confirm_password') }}">
                                @if ($errors->has('confirm_password'))
                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label class="form-label">&nbsp; </label>
                            </div>
                            <div class="col-lg-4">
                                <button type="submit" name="submit" value="submit" class="btn btn-primary">
                                    <i class="icon-ok bigger-110"></i>
                                    Change Password
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
