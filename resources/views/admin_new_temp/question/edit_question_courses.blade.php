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
                    <form action="{{ url('/admin/question/update') }}" method="post" accept-charset="utf-8"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($errors->has('id'))
                            <strong>{{ $errors->first('id') }}</strong>
                        @endif
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="question" class="form-label">Enter Question *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" required="required" name="question" id="question"
                                    placeholder="Enter Question" class="form-control"
                                    value="{{ old('question') ? old('question') : $getQuestion->question }}">

                                @if ($errors->has('question'))
                                    <strong>{{ $errors->first('question') }}</strong>
                                @endif
                            </div>
                        </div>

                        @php
                            $option = json_decode($getQuestion->options);
                            $answer = array_search($getQuestion->ans, (array) $option);
                        @endphp

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="option_1" class="form-label">Enter Option 1</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" required="required" name="option_1" placeholder="Enter Question"
                                    class="form-control"
                                    value="{{ old('option_1') ? old('option_1') : $option->option_1 }}">
                                @if ($errors->has('option_1'))
                                    <strong>{{ $errors->first('option_1') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="option_2" class="form-label">Enter Option 2</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" required="required" name="option_2" placeholder="Enter Option 2"
                                    class="form-control"
                                    value="{{ old('option_2') ? old('option_2') : $option->option_2 }}">
                                @if ($errors->has('option_2'))
                                    <strong>{{ $errors->first('option_2') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="option_3" class="form-label">Enter Option 3</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="option_3" placeholder="Enter  Option 3" class="form-control"
                                    value="{{ old('option_3') ? old('option_3') : $option->option_3 }}">
                                @if ($errors->has('option_3'))
                                    <strong>{{ $errors->first('option_3') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="option_4" class="form-label">Enter Option 4</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="option_4" placeholder="Enter  Option 4" class="form-control"
                                    value="{{ old('option_4') ? old('option_4') : $option->option_4 }}">
                                @if ($errors->has('option_4'))
                                    <strong>{{ $errors->first('option_4') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="ans" class="form-label">Select correct option</label>
                            </div>
                            <div class="col-lg-6">
                                <select class="form-control" required="required" name="ans">
                                    <option value="">Select</option>
                                    <option value="option_1" {{ $answer == 'option_1' ? 'selected' : '' }}>option 1
                                    </option>
                                    <option value="option_2" {{ $answer == 'option_2' ? 'selected' : '' }}>option 2
                                    </option>
                                    <option value="option_3" {{ $answer == 'option_3' ? 'selected' : '' }}>option 3
                                    </option>
                                    <option value="option_4" {{ $answer == 'option_4' ? 'selected' : '' }}>option 4
                                    </option>
                                </select>
                                @if ($errors->has('ans'))
                                    <strong>{{ $errors->first('ans') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="image" class="form-label">Image</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="file" name="image" id="image" class="form-control image-box" />
                                @if ($errors->has('image'))
                                    <strong>{{ $errors->first('image') }}</strong>
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

                        @if ($getQuestion->file != '')
                            <div class="row mb-3">
                                <div class="col-lg-2 custom-text-align">
                                    <label for="duration" class="form-label">Previous Image</label>
                                </div>
                                <div class="col-lg-6">
                                    <img src="{{ asset('storage/app/public/image/question/' . $getQuestion->file) }}"
                                        alt="previous-image" style="width: 200px">
                                </div>
                            </div>
                        @endif
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

        /* .form-control {
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
            } */

        .image-box {
            margin-bottom: 8px;
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
