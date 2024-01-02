@extends('layouts.admin.layer')
@section('title', 'Update Student Details | Driving School')
@section('content')
    <link href="{{ asset('assets/student/css/datepicker.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/student/js/bootstrap-datepicker.js') }}"></script>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Update Student Details</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Update Student Details</h4>
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
                    <form action="{{ url('admin/student/' . $getUserInfo->id . '/update') }}" method="post"
                        class="form-horizontal" accept-charset="utf-8">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">First name *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('first_name') ? old('first_name') : $getUserInfo->first_name }}"
                                    name="first_name" />
                                @if ($errors->has('first_name'))
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">Last name</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('last_name') ? old('last_name') : $getUserInfo->last_name }}"
                                    name="last_name" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">Email *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" class="form-control"
                                    value="{{ old('email') ? old('email') : $getUserInfo->email }}" name="email" />
                                @if ($errors->has('email'))
                                    <strong>{{ $errors->first('email') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">Mobile No </label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" class="form-control"
                                    value="{{ old('mobile_no') ? old('mobile_no') : $getUserInfo->mobile_no }}"
                                    name="mobile_no" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">DOB *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('dob') ? old('dob') : $getUserInfo->dob }}" name="dob"
                                    placeholder="yyyy-mm-dd" id="datepicker" />
                                @if ($errors->has('dob'))
                                    <strong>{{ $errors->first('dob') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">Gender *</label>
                            </div>
                            <div class="col-lg-6">
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select</option>
                                    <option value="male"
                                        {{ (old('gender') == 'male' ? 'selected' : $getUserInfo->gender == 'male') ? 'selected' : '' }}>
                                        Male
                                    </option>
                                    <option value="female"
                                        {{ (old('gender') == 'female' ? 'selected' : $getUserInfo->gender == 'female') ? 'selected' : '' }}>
                                        Female</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <strong>{{ $errors->first('gender') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">address1 *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('address1') ? old('address1') : $getUserInfo->address1 }}"
                                    name="address1" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">address2 </label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('address2') ? old('address2') : $getUserInfo->address2 }}"
                                    name="address2" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">Postcode </label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('postcode') ? old('postcode') : $getUserInfo->postcode }}"
                                    name="postcode" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">City/Town </label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('city_town') ? old('city_town') : $getUserInfo->city_town }}"
                                    name="city_town" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">Country </label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('country') ? old('country') : $getUserInfo->country }}"
                                    name="country" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">Status </label>
                            </div>
                            <div class="col-lg-6">
                                <select name="status" id="status1" class="form-control">
                                    <option value="1"
                                        {{ (old('status') == '1' ? 'selected' : $getUserInfo->status == '1') ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0"
                                        {{ (old('status') == '0' ? 'selected' : $getUserInfo->status == '0') ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                @if ($errors->has('status'))
                                    <strong>{{ $errors->first('status') }}</strong>
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
                                    Save Change
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--/.row-fluid-->
    <script>
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
    </script>
@endsection
