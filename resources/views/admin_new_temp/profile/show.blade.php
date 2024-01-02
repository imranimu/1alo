@extends('layouts.admin.layer')
@section('title', 'Profile | Driving School')
@section('content')

    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ asset('assets/admin/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">
            <div class="overlay-content">
                <div class="text-end p-3">
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            @if (Auth::user()->image != '')
                                <img id="avatar" class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                    alt="user-profile"
                                    src="{{ asset('storage/app/public/image/avatars/' . Auth::user()->image) }}" />
                            @else
                                <img id="avatar" class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                    alt="user-profile" src="{{ asset('assets/admin/avatars/no-image.jpg') }}"
                                    alt="User image" />
                            @endif
                        </div>
                        <h5 class="fs-16 mb-1">{{ ucwords(Auth::user()->first_name . ' ' . Auth::user()->last_name) }}</h5>
                        <p class="text-muted mb-0">Admin</p>
                    </div>
                </div>
            </div>



        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i> Personal Details
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="javascript:void(0);">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="firstnameInput" class="form-label">Name</label>
                                            <label class="form-control" id="firstnameInput">
                                                {{ ucwords(Auth::user()->first_name . ' ' . Auth::user()->last_name) }}
                                            </label>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastnameInput" class="form-label">Username</label>
                                            <label class="form-control" id="firstnameInput">
                                                {!! Auth::user()->username != '' ? Auth::user()->username : '&nbsp;' !!}
                                            </label>
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
                                            <label for="emailInput" class="form-label">Mobile No</label>
                                            <label class="form-control" id="firstnameInput">
                                                {{ Auth::user()->mobile_no }}
                                            </label>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="JoiningdatInput" class="form-label">User Role</label>
                                            <label class="form-control" id="firstnameInput">
                                                @if (Auth::user()->is_role == 1)
                                                    Admin
                                                @else
                                                    Other
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="skillsInput" class="form-label">Statis</label>
                                            <label class="form-control" id="firstnameInput">
                                                @if (Auth::user()->is_role == 1)
                                                    <span class="editable" id="about">Active</span>
                                                @else
                                                    <span class="editable" id="about">Inactive</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="{{ url('admin/profile/' . Auth::user()->id . '/edit') }}"
                                                class="btn btn-primary">
                                                Edit Profile
                                            </a>
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
    <!--end row-->
@endsection
