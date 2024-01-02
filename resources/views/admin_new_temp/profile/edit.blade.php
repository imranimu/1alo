@extends('layouts.admin.layer')
@section('title', 'Edit Profile | Driving School')
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Update Profile</li>
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
                                <i class="fas fa-home"></i> Update Profile
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            @if (session('message'))
                                <div class="control-group">
                                    <div class="alert alert-success inline">
                                        {{ session('message') }}
                                    </div>
                                </div>
                            @endif
                            <form accept-charset="utf-8" method="post" action="{{ url('admin/profile/' . $data->id) }}"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" placeholder="First Name"
                                                name="first_name" id="first_name"
                                                value="{{ isset($data->first_name) ? $data->first_name : old('first_name') }}"
                                                required>
                                            @if ($errors->has('first_name'))
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" placeholder="Last Name"
                                                name="last_name" id="last_name"
                                                value="{{ isset($data->last_name) ? $data->last_name : old('last_name') }}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Email Address</label>
                                            <label class="form-control" id="firstnameInput">
                                                {{ Auth::user()->email }}
                                            </label>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="mobile_no" class="form-label">Mobile No.</label>
                                            <input type="text" class="form-control" placeholder="Mobile No"
                                                name="mobile_no" id="mobile_no"
                                                value="{{ isset($data->mobile_no) ? $data->mobile_no : old('mobile_no') }}"
                                                required>
                                            @if ($errors->has('mobile_no'))
                                                <strong>{{ $errors->first('mobile_no') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Image Upload</label>
                                            <input type="file" class="form-control"name="image" id="image"
                                                value="">
                                            @if ($errors->has('image'))
                                                <strong>{{ $errors->first('image') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" name="submit" value="submit" class="btn btn-primary">
                                                <i class="icon-ok bigger-110"></i>
                                                Update
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
