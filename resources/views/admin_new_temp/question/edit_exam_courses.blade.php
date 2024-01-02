@extends('layouts.admin.layer')

@section('title', 'Question Lists | Driving School')

@section('content')
    <script src="{{ url('assets/admin/js/bootbox.js') }}"></script>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Edit Exam</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Edit Exam</h4>
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
                    <form action="{{ url('/admin/question/update-exam') }}" method="post">
                        @csrf
                        @if ($errors->has('id'))
                            <strong>{{ $errors->first('id') }}</strong>
                        @endif
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="question" class="form-label">Enter title</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" required="required" name="title"
                                    value="{{ old('title') ? old('title') : $getExam->title }}" placeholder="Enter title"
                                    class="form-control">

                                @if ($errors->has('title'))
                                    <strong>{{ $errors->first('title') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="question" class="form-label">Select course</label>
                            </div>
                            <div class="col-lg-6">
                                <select class="form-control" required="required" name="exam_courses"
                                    onchange="getModule(this.value)">
                                    <option value="">Select</option>
                                    @if (!blank($getCourses))
                                        @php $courses = old('exam_courses') ? old('exam_courses') : $getExam->courses_id @endphp
                                        @foreach ($getCourses as $val)
                                            <option value="{{ $val->id }}"
                                                {{ $courses == $val->id ? 'selected' : '' }}>
                                                {{ $val->title }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('exam_category'))
                                    <strong>{{ $errors->first('exam_category') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="question" class="form-label">Select module</label>
                            </div>
                            <div class="col-lg-6">
                                <select class="form-control" required="required" name="exam_module" id="exam_module">
                                    <option value="">Select</option>
                                    @if (!blank($getModule))
                                        @php $module = old('exam_courses') ? old('exam_courses') : $getExam->module_id @endphp
                                        @foreach ($getModule as $val)
                                            <option value="{{ $val->id }}"
                                                {{ $module == $val->id ? 'selected' : '' }}>
                                                {{ $val->name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('exam_category'))
                                    <strong>{{ $errors->first('exam_category') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="question" class="form-label">Status</label>
                            </div>
                            <div class="col-lg-6">
                                <select class="form-control" required="required" name="status">
                                    <option value="">Select</option>
                                    <option value="1"
                                        {{ (old('status') == '1' ? 'selected' : $getExam->status == '1') ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0"
                                        {{ (old('status') == '0' ? 'selected' : $getExam->status == '0') ? 'selected' : '' }}>
                                        Inactive
                                    </option>
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
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .radio.controls.radio-p-0 {
            margin-left: 160px !important;
        }

        label.radio-float {
            float: left;
            margin-right: 10px;
        }

        .pager {
            text-align: left;
        }

        .show-count {
            margin-right: 10px;
        }

        .header-title {
            margin-left: 0;
        }

        .btn-user {
            text-align: right;
            display: inline-block;
        }

        .modal-header .close {
            font-size: 20px;
        }

        .modal-header .close {
            margin-top: -28px;
        }

        .form-control {
            display: block;
            width: 98%;
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-shadow: inset 0 0 0 transparent;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
    </style>
    <script>
        function getModule(id) {
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/question/get-module') }}',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    let html = '<option value="">Select</option>';
                    for (const val of response) {
                        console.log(val.name);
                        html += '<option value="' + val.id + '">' + val.name + '</option>';
                    }
                    $('#exam_module').html(html);
                }
            });
        }

        function examDelete(id) {
            bootbox.confirm({
                message: "Do you want to delete?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function(result) {
                    if (result == true) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('admin/question/exam-delete') }}',
                            data: {
                                "id": id,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true
                                }
                                if (response.status == 1) {
                                    toastr.success(response.text);
                                    location.reload();
                                } else if (response.status == 2) {
                                    toastr.error(response.text);
                                } else {
                                    toastr.error(response.text);
                                }
                            }
                        });
                    }
                }
            });
        }
    </script>
@endsection
