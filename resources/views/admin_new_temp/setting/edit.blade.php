@extends('layouts.admin.layer')
@section('title', 'Setting Edit | Driving School')
@section('content')
    <script src="{{ url('assets/admin/js/ckeditor/ckeditor.js') }}"></script>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Setting</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Update setting</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="control-group">
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
                    </div>

                    <!--PAGE CONTENT BEGINS-->
                    <form accept-charset="utf-8" method="post" action="{{ url('admin/setting/update') }}"
                        class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ isset($data->id) ? $data->id : '0' }}" name="id">
                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">Title *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Title" class="form-control" name="title" id="title"
                                    value="{{ isset($data->title) ? $data->title : old('title') }}" required>
                                @if ($errors->has('title'))
                                    <strong>{{ $errors->first('title') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="mobile_no" class="form-label">Mobile No *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Mobile No" class="form-control" name="mobile_no"
                                    id="mobile_no"
                                    value="{{ isset($data->mobile_no) ? $data->mobile_no : old('mobile_no') }}" required>
                                @if ($errors->has('mobile_no'))
                                    <strong>{{ $errors->first('mobile_no') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="phone_no" class="form-label">Footer Mobile No *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Phone No" class="form-control" name="phone_no"
                                    id="phone_no" value="{{ isset($data->phone_no) ? $data->phone_no : old('phone_no') }}"
                                    required>
                                @if ($errors->has('phone_no'))
                                    <strong>{{ $errors->first('phone_no') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="email" class="form-label">Email *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Email" class="form-control" name="email" id="email"
                                    value="{{ isset($data->email) ? $data->email : old('email') }}" required>
                                @if ($errors->has('email'))
                                    <strong>{{ $errors->first('email') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="address" class="form-label">Address *</label>
                            </div>
                            <div class="col-lg-6">
                                <textarea placeholder="Address" class="form-control" name="address" id="address" required>
                                    {{ isset($data->address) ? ltrim($data->address) : old('address') }}
                                </textarea>
                                @if ($errors->has('address'))
                                    <strong>{{ $errors->first('address') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="facebook_link" class="form-label">Facebook Link</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Facebook Link" class="form-control" name="facebook_link"
                                    id="facebook_link"
                                    value="{{ isset($data->facebook_link) ? $data->facebook_link : old('facebook_link') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="instagram_link" class="form-label">Instagram Link</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Instagram Link" class="form-control"
                                    name="instagram_link" id="instagram_link"
                                    value="{{ isset($data->instagram_link) ? $data->instagram_link : old('instagram_link') }}">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="pinterest_link" class="form-label">Pinterest Link</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Pinterest Link" class="form-control"
                                    name="pinterest_link" id="pinterest_link"
                                    value="{{ isset($data->pinterest_link) ? $data->pinterest_link : old('pinterest_link') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="linkedin_link" class="form-label">Linkedin Link</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Linkedin Link" class="form-control"
                                    name="linkedin_link" id="linkedin_link"
                                    value="{{ isset($data->linkedin_link) ? $data->linkedin_link : old('linkedin_link') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="twitter_link" class="form-label">Twitter Link</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Linkedin Link" class="form-control"
                                    name="twitter_link" id="twitter_link"
                                    value="{{ isset($data->twitter_link) ? $data->twitter_link : old('twitter_link') }}">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="youtube_link" class="form-label">Youtube Link</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Youtube Link" class="form-control"
                                    name="youtube_link" id="youtube_link"
                                    value="{{ isset($data->youtube_link) ? $data->youtube_link : old('youtube_link') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label class="form-label">&nbsp; </label>
                            </div>
                            <div class="col-lg-4">
                                <button type="submit" name="submit" value="submit" class="btn btn-primary">
                                    <i class="icon-ok bigger-110"></i>
                                    Update
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
