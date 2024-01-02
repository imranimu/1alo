@extends('layouts.admin.layer')
@section('title', 'Change Passwrod | Manchester School')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!--end col-->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i> Change Password
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
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
                            <form action="{{ url($action_url) }}" method="post" class="form-horizontal"
                                enctype="multipart/form-data" accept-charset="utf-8">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="current_Password" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" placeholder="Current Password"
                                                name="current_Password" id="current_Password"
                                                value="{{ isset(Session::get('message')['current_pass']) ? Session::get('message')['current_pass'] : old('current_Password') }}">
                                            @if ($errors->has('current_Password'))
                                                <strong>{{ $errors->first('current_Password') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" placeholder="New Password"
                                                name="new_password" id="new_password"
                                                value="{{ isset(Session::get('message')['new_pass']) ? Session::get('message')['new_pass'] : old('new_password') }}">
                                            @if ($errors->has('new_password'))
                                                <strong>{{ $errors->first('new_password') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" placeholder="Confirm Password"
                                                name="confirm_password" id="confirm_password"
                                                value="{{ isset(Session::get('message')['confirm_pass']) ? Session::get('message')['confirm_pass'] : old('confirm_password') }}">
                                            @if ($errors->has('confirm_password'))
                                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" name="submit" value="Change Password"
                                                class="btn btn-primary">
                                                <i class="icon-ok bigger-110"></i>
                                                Change Password
                                            </button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
@endsection
