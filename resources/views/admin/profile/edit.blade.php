@extends('layouts.admin.layer')
@section('title', 'Edit Profile | Manchester School')
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
        <li class="active">Update Profile</li>
    </ul>
    <!--.breadcrumb-->
</div>

<div class="page-content">
    <div class="page-header position-relative">
        <h1>Update Profile</h1>
    </div>
    <!--/.page-header-->

    <div class="row-fluid">
        <div class="span12">
            @if (session('message'))
            <div class="control-group">
                    <div class="alert alert-success inline">
                        {{ session('message') }}
                    </div>
            </div>
            @endif
            <!--PAGE CONTENT BEGINS-->
            <form accept-charset="utf-8" method="post" action="{{ url('admin/profile/'.$data->id) }}" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}

                <div class="control-group">
                    <label class="control-label" for="form-field-1">First Name</label>
                    <div class="controls">
                        <input type="text" placeholder="First Name" name="first_name" id="first_name" value="{{ isset($data->first_name) ? $data->first_name : old('first_name') }}" required>
                        @if ($errors->has('first_name'))
                            <strong>{{ $errors->first('first_name') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Last Name</label>
                    <div class="controls">
                        <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="{{ isset($data->last_name) ? $data->last_name : old('last_name') }}">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Email</label>
                    <div class="controls">
                        <label>{{ $data->email }}</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Mobile Number</label>
                    <div class="controls">
                        <input type="text" placeholder="Mobile No" name="mobile_no" id="mobile_no" value="{{ isset($data->mobile_no) ? $data->mobile_no : old('mobile_no') }}" required>
                        @if ($errors->has('mobile_no'))
                            <strong>{{ $errors->first('mobile_no') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Image Upload</label>
                    <div class="controls">
                        <input type="file"name="image" id="image" value="">
                        @if ($errors->has('image'))
                            <strong>{{ $errors->first('image') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" value="submit" class="btn btn-info">
                        <i class="icon-ok bigger-110"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
        <!--PAGE CONTENT ENDS-->
    </div>
    <!--/.span-->

</div>
<!--/.row-fluid-->

@endsection
