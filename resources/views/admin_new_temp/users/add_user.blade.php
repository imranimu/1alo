@extends('layouts.admin.layer')

@section('title', 'Add User | Driving School')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/admin/css/plugins/select2.css') }}">
    <script type="text/javascript" src="{{ url('assets/admin/js/plugins/select2.min.js') }}"></script>
    <script src="{{ url('assets/admin/js/bootbox.js') }}"></script>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Add User</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Add User</h4>
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
                    <form action="{{ url('admin/user/store-user') }}" method="post" class="form-horizontal"
                        accept-charset="utf-8">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="first_name" class="form-label">First name *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('first_name') ? old('first_name') : '' }}" name="first_name" />
                                @if ($errors->has('first_name'))
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="last_name" class="form-label">Last name </label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('last_name') ? old('last_name') : '' }}" name="last_name" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="email" class="form-label">Email *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" class="form-control" value="{{ old('email') ? old('email') : '' }}"
                                    name="email" />
                                @if ($errors->has('email'))
                                    <strong>{{ $errors->first('email') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="mobile_no" class="form-label">Mobile No</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" class="form-control"
                                    value="{{ old('mobile_no') ? old('mobile_no') : '' }}" name="mobile_no" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="address1" class="form-label">address1</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('address1') ? old('address1') : '' }}" name="address1" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="address2" class="form-label">address2</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('address2') ? old('address2') : '' }}" name="address2" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="city_town" class="form-label">City/Town</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('city_town') ? old('city_town') : '' }}" name="city_town" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="postcode" class="form-label">Postcode</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('postcode') ? old('postcode') : '' }}" name="postcode" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="country" class="form-label">Country</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control"
                                    value="{{ old('country') ? old('country') : '' }}" name="country" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="password" class="form-label">Password *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="password" class="form-control"
                                    value="{{ old('password') ? old('password') : '' }}" name="password" />
                                @if ($errors->has('password'))
                                    <strong>{{ $errors->first('password') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="status1" class="form-label">Status *</label>
                            </div>
                            <div class="col-lg-6">
                                <select name="status" id="status1" class="form-control">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
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
                                    ADD
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
