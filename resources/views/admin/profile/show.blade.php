@extends('layouts.admin.layer')
@section('title', 'Profile | Manchester School')
@section('content')
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">Home</a>
            <span class="divider">
                <i class="icon-angle-right arrow-icon"></i>
            </span>
        </li>
        <li class="active">User Profile</li>
    </ul>
    <!--.breadcrumb-->
</div>

<div class="page-content">
    <div class="page-header position-relative">
        <h1>User Profile Page</h1>
    </div>
    <!--/.page-header-->

    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <div>
                <div id="user-profile-1" class="user-profile row-fluid">
                    <div class="span3 center">
                        <div>
                            <a type="button" data-toggle="modal" data-target="#exampleModal">
                                <span class="profile-picture">
                                    @if (Auth::user()->image !="")
                                        <img id="avatar" class="editable" alt="user-profile" src="{{ asset('storage/app/public/image/avatars/'.Auth::user()->image) }}" />
                                    @else
                                        <img id="avatar" class="editable" alt="user-profile" src="{{ asset('assets/admin/avatars/no-image.jpg') }}" alt="User image"/>
                                    @endif
                                </span>
                            </a>
                            <div class="space-4"></div>

                            <div class="width-80 label label-info label-large arrowed-in arrowed-in-right">
                                <div class="inline position-relative">
                                    <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-circle light-green middle"></i>
                                        &nbsp;
                                        <span class="white middle bigger-120">
                                            {{ ucwords(Auth::user()->first_name.' '. Auth::user()->last_name) }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="space-6"></div>

                        <div class="profile-contact-info">
                            <div class="profile-contact-links align-left">
                                <a class="btn btn-link" href="mailto:{{ Auth::user()->email }}">
                                    <i class="icon-envelope bigger-120 pink"></i>
                                    {{ Auth::user()->email }}
                                </a>
                            </div>
                            <div class="space-6"></div>
                        </div>

                        <div class="hr hr12 dotted"></div>

                    </div>

                    <div class="span9">
                        <div class="center">

                        </div>

                        <div class="space-12"></div>

                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Name </div>

                                <div class="profile-info-value">
                                    <span class="editable" id="username">
                                        {{ ucwords(Auth::user()->first_name.' '. Auth::user()->last_name) }}
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Username </div>
                                <div class="profile-info-value">
                                    <span class="editable" id="country">
                                        {{ Auth::user()->username }}
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Email Address </div>
                                <div class="profile-info-value">
                                    <span class="editable" id="age">
                                        {{ Auth::user()->email }}
                                    </span>
                                </div>
                            </div>

                            @if (isset(Auth::user()->mobile_no))
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Mobile No </div>
                                    <div class="profile-info-value">
                                        <span class="editable" id="age">
                                            {{ Auth::user()->mobile_no }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <div class="profile-info-row">
                                <div class="profile-info-name"> User Role </div>
                                <div class="profile-info-value">
                                    <span class="editable" id="signup">
                                        @if (Auth::user()->is_role == 1)
                                            Admin
                                        @else
                                            Other
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Status </div>
                                <div class="profile-info-value">
                                    @if (Auth::user()->is_role == 1)
                                        <span class="editable" id="about">Active</span>
                                    @else
                                        <span class="editable" id="about">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ url('admin/profile/'.Auth::user()->id.'/edit') }}" class="pull-right btn btn-primary">Edit Profile</a>
                        </div>

                        <div class="space-20"></div>
                        <div class="hr hr2 hr-double"></div>
                        <div class="space-6"></div>
                    </div>
                </div>
            </div>

            <!--PAGE CONTENT ENDS-->
        </div>
        <!--/.span-->
    </div>
    <!--/.row-fluid-->
</div>
<!--/.page-content-->
</script>
@endsection
