@extends('layouts.admin.layer')
@section('title', 'Setting Edit | Driving School')
@section('content')
    <div class="breadcrumbs" id="breadcrumbs">
        <script src="{{ url('assets/admin/js/ckeditor/ckeditor.js') }}"></script>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="#">Home</a>

                <span class="divider">
                    <i class="icon-angle-right arrow-icon"></i>
                </span>
            </li>
            <li class="active">Setting</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>Update setting</h1>
        </div>
        <!--/.page-header-->

        <div class="row-fluid">
            <div class="span12">

                <!-- Message here -->
                @if (!empty(Session::get('message')) && isset(Session::get('message')['status']) == '1')
                    <div class="control-group">
                        <div class="alert alert-success inline">
                            {{ Session::get('message')['text'] }}
                        </div>
                    </div>
                @elseif (!empty(Session::get('message')) && isset(Session::get('message')['status']) == '0')
                    <div class="control-group">
                        <div class="alert alert-danger inline">
                            {{ Session::get('message')['text'] }}
                        </div>
                    </div>
                @endif

                <!--PAGE CONTENT BEGINS-->
                <form accept-charset="utf-8" method="post" action="{{ url('admin/setting/update') }}"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ isset($data->id) ? $data->id : '0' }}" name="id">
                    <div class="control-group">
                        <label class="control-label" for="title">Title: *</label>
                        <div class="controls">
                            <input type="text" placeholder="Title" name="title" id="title"
                                value="{{ isset($data->title) ? $data->title : old('title') }}" required>
                            @if ($errors->has('title'))
                                <strong>{{ $errors->first('title') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="mobile_no">Mobile No: *</label>
                        <div class="controls">
                            <input type="text" placeholder="Mobile No" name="mobile_no" id="mobile_no"
                                value="{{ isset($data->mobile_no) ? $data->mobile_no : old('mobile_no') }}" required>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label" for="phone_no">Footer Mobile No: *</label>
                        <div class="controls">
                            <input type="text" placeholder="Phone No" name="phone_no" id="phone_no"
                                value="{{ isset($data->phone_no) ? $data->phone_no : old('phone_no') }}" required>
                            @if ($errors->has('phone_no'))
                                <strong>{{ $errors->first('phone_no') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="email">Email: *</label>
                        <div class="controls">
                            <input type="text" placeholder="Email" name="email" id="email"
                                value="{{ isset($data->email) ? $data->email : old('email') }}" required>
                            @if ($errors->has('email'))
                                <strong>{{ $errors->first('email') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="address">Address: *</label>
                        <div class="controls">
                            <textarea placeholder="Address" name="address" id="address" required>
                            {{ isset($data->address) ? $data->address : old('address') }}
                        </textarea>
                            @if ($errors->has('address'))
                                <strong>{{ $errors->first('address') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="facebook_link">Facebook Link</label>
                        <div class="controls">
                            <input type="text" placeholder="Facebook Link" name="facebook_link" id="facebook_link"
                                value="{{ isset($data->facebook_link) ? $data->facebook_link : old('facebook_link') }}">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="instagram_link">Instagram Link</label>
                        <div class="controls">
                            <input type="text" placeholder="Instagram Link" name="instagram_link" id="instagram_link"
                                value="{{ isset($data->instagram_link) ? $data->instagram_link : old('instagram_link') }}">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="pinterest_link">Pinterest Link</label>
                        <div class="controls">
                            <input type="text" placeholder="Pinterest Link" name="pinterest_link" id="pinterest_link"
                                value="{{ isset($data->pinterest_link) ? $data->pinterest_link : old('pinterest_link') }}">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="linkedin_link">Linkedin Link</label>
                        <div class="controls">
                            <input type="text" placeholder="Linkedin Link" name="linkedin_link" id="linkedin_link"
                                value="{{ isset($data->linkedin_link) ? $data->linkedin_link : old('linkedin_link') }}">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="twitter_link">Twitter Link</label>
                        <div class="controls">
                            <input type="text" placeholder="Linkedin Link" name="twitter_link" id="twitter_link"
                                value="{{ isset($data->twitter_link) ? $data->twitter_link : old('twitter_link') }}">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="youtube_link">Youtube Link</label>
                        <div class="controls">
                            <input type="text" placeholder="Youtube Link" name="youtube_link" id="youtube_link"
                                value="{{ isset($data->youtube_link) ? $data->youtube_link : old('youtube_link') }}">
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
