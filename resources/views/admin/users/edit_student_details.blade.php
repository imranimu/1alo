@extends('layouts.admin.layer')
@section('title', 'Update Student Details | Driving School')
@section('content')
	<link href="{{ asset('assets/student/css/datepicker.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/student/js/bootstrap-datepicker.js') }}"></script>

    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="#">Home</a>
                <span class="divider">
                    <i class="icon-angle-right arrow-icon"></i>
                </span>
            </li>
            <li class="active">Update Student Details</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>Update Student Details</h1>
        </div>

        <!--/.page-header-->

        <div class="row-fluid">

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

            <div class="span12">
                <form action="{{ url('admin/student/' . $getUserInfo->id . '/update') }}" method="post"
                    class="form-horizontal" accept-charset="utf-8">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="control-group">
                        <label class="control-label col-lg-2">First name *</label>
                        @if ($errors->has('first_name'))
                            <strong>{{ $errors->first('first_name') }}</strong>
                        @endif
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('first_name') ? old('first_name') : $getUserInfo->first_name }}"
                                name="first_name" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Last name</label>
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('last_name') ? old('last_name') : $getUserInfo->last_name }}"
                                name="last_name" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Email</label>
                        @if ($errors->has('email'))
                            <strong>{{ $errors->first('email') }}</strong>
                        @endif
                        <div class="controls">
                            <input type="email" class="form-control"
                                value="{{ old('email') ? old('email') : $getUserInfo->email }}" name="email" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Mobile No *</label>
                        <div class="controls">
                            <input type="number" class="form-control"
                                value="{{ old('mobile_no') ? old('mobile_no') : $getUserInfo->mobile_no }}"
                                name="mobile_no" />
                        </div>
                    </div>
					
					<div class="control-group">
                        <label class="control-label col-lg-2">DOB *</label>
						@if ($errors->has('dob'))
                            <strong>{{ $errors->first('dob') }}</strong>
                        @endif
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('dob') ? old('dob') : $getUserInfo->dob }}"
                                name="dob"  placeholder="yyyy-mm-dd" id="datepicker" />
                        </div>
                    </div>
					
					<div class="control-group">
                        <label class="control-label col-lg-2">Gender *</label>
						@if ($errors->has('gender'))
                            <strong>{{ $errors->first('gender') }}</strong>
                        @endif
                        <div class="controls">
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
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">address1: </label>
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('address1') ? old('address1') : $getUserInfo->address1 }}" name="address1" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">address2: </label>
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('address2') ? old('address2') : $getUserInfo->address2 }}" name="address2" />
                        </div>
                    </div>
					
					<div class="control-group">
                        <label class="control-label col-lg-2">Postcode: </label>
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('postcode') ? old('postcode') : $getUserInfo->postcode }}" name="postcode" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">City/Town: </label>
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('city_town') ? old('city_town') : $getUserInfo->city_town }}"
                                name="city_town" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Country: </label>
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('country') ? old('country') : $getUserInfo->country }}" name="country" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Status: </label>
                        <div class="controls">
                            <select name="status" id="status">
                                <option value="1"
                                    {{ (old('status') == '1' ? 'selected' : $getUserInfo->status == '1') ? 'selected' : '' }}>
                                    Active</option>
                                <option value="0"
                                    {{ (old('status') == '0' ? 'selected' : $getUserInfo->status == '0') ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">&nbsp;</label>
                        <div class="controls">
                            <input type="submit" value="Save Change" class="search-btn btn btn-primary">
                        </div>
                    </div>
                </form>

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
