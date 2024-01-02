@extends('layouts.admin.layer')

@section('title', 'Add User | Driving School')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/admin/css/plugins/select2.css') }}">
    <script type="text/javascript" src="{{ url('assets/admin/js/plugins/select2.min.js') }}"></script>
    <script src="{{ url('assets/admin/js/bootbox.js') }}"></script>

    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="#">Home</a>
                <span class="divider">
                    <i class="icon-angle-right arrow-icon"></i>
                </span>
            </li>
            <li class="active">Add User</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>Add User</h1>
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
                <form action="{{ url('admin/user/store-user') }}" method="post" class="form-horizontal"
                    accept-charset="utf-8">
                    @csrf
                    <div class="control-group">
                        <label class="control-label col-lg-2">First name *</label>
                        @if ($errors->has('first_name'))
                            <strong>{{ $errors->first('first_name') }}</strong>
                        @endif
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('first_name') ? old('first_name') : '' }}" name="first_name" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Last name</label>
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('last_name') ? old('last_name') : '' }}" name="last_name" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Email *</label>
                        @if ($errors->has('email'))
                            <strong>{{ $errors->first('email') }}</strong>
                        @endif
                        <div class="controls">
                            <input type="email" class="form-control" value="{{ old('email') ? old('email') : '' }}"
                                name="email" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Mobile No </label>
                        <div class="controls">
                            <input type="number" class="form-control"
                                value="{{ old('mobile_no') ? old('mobile_no') : '' }}" name="mobile_no" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">address1 </label>
                        <div class="controls">
                            <input type="text" class="form-control" value="{{ old('address1') ? old('address1') : '' }}"
                                name="address1" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">address2 </label>
                        <div class="controls">
                            <input type="text" class="form-control" value="{{ old('address2') ? old('address2') : '' }}"
                                name="address2" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">City/Town</label>
                        <div class="controls">
                            <input type="text" class="form-control"
                                value="{{ old('city_town') ? old('city_town') : '' }}" name="city_town" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Postcode </label>
                        <div class="controls">
                            <input type="text" class="form-control" value="{{ old('postcode') ? old('postcode') : '' }}"
                                name="postcode" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Country </label>
                        <div class="controls">
                            <input type="text" class="form-control" value="{{ old('country') ? old('country') : '' }}"
                                name="country" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Password * </label>
                        @if ($errors->has('password'))
                            <strong>{{ $errors->first('password') }}</strong>
                        @endif
                        <div class="controls">
                            <input type="password" class="form-control"
                                value="{{ old('password') ? old('password') : '' }}" name="password" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label col-lg-2">Status: </label>
                        <div class="controls">
                            <select name="status" id="status">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
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
        function OtherDesignation(val, is_type) {
            if (val == 'other') {
                if (is_type == 0) {
                    $('#other-designation').attr('type', 'text');
                    $('#edit_other_designation').val('');
                } else {
                    $('#edit_other_designation').attr('type', 'text');
                }
            } else {
                if (is_type == 0) {
                    $('#other-designation').attr('type', 'hidden');
                    $('#edit_other_designation').val('');
                } else {
                    $('#edit_other_designation').attr('type', 'hidden');
                }
            }
        }

        $(".js-select2").select2({
            closeOnSelect: false,
            placeholder: "Select Subject",
            allowHtml: true,
            allowClear: true,
            tags: true
        });
    </script>
@endsection
