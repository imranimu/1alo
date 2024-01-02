@extends('layouts.admin.layer')
@section('title', 'Course Lesson Add | Driving School')
@section('content')
    <link href="{{ url('assets/admin/css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/admin/css/components.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ url('assets/admin/js/bootbox.js') }}"></script>
    <script src="{{ url('assets/admin/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/admin/js/pages/components_navs.js') }}"></script>
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="#">Home</a>

                <span class="divider">
                    <i class="icon-angle-right arrow-icon"></i>
                </span>
            </li>
            <li class="active">Course Lesson Add</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>Course Lesson Add</h1>
        </div>
        <!--/.page-header-->

        <div class="row-fluid">
            <div class="span5">
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
                <form action="{{ route('admin.course.store-course-lesson') }}" accept-charset="utf-8" method="post"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="control-group">
                        <label class="control-label">Course Name: </label>
                        <div class="controls">
                            <label class="form-control"><b>{{ $get_course->title }}</b></label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Title * </label>
                        <div class="controls">
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title') }}" placeholder="Title">
                            @if ($errors->has('title'))
                                <strong>{{ $errors->first('title') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="lesson_type">Lesson Type *</label>
                        <div class="controls">
                            <select name="lesson_type" id="lesson_type" class="form-control"
                                onchange="addLesson(this.value)">
                                <option value="">Select Level</option>
                                @if (getLessonType() != '')
                                    @foreach (getLessonType() as $val)
                                        <option value="{{ $val }}"
                                            {{ old('lesson_type') == $val ? 'selected' : '' }}>
                                            {{ $val }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('lesson_type'))
                                <strong>{{ $errors->first('lesson_type') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group" id="file_box">
                        <label class="control-label" for="file" id="file_txt">Video</label>
                        <div class="controls">
                            <input type="file" name="file" id="file" class="form-control" />
                            @if ($errors->has('file'))
                                <strong>{{ $errors->first('file') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="file_pdf_text">PDF/TEXT</label>
                        <div class="controls">
                            <input type="file" name="file_pdf_text" id="file_pdf_text" class="form-control" />
                            @if ($errors->has('file_pdf_text'))
                                <strong>{{ $errors->first('file_pdf_text') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="page">Status *</label>
                        <div class="controls">
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @if ($errors->has('status'))
                                <strong>{{ $errors->first('status') }}</strong>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" value="{{ $id }}" name="id">
                    <div class="form-actions">
                        <button type="submit" name="submit" value="submit" class="btn btn-info" onclick="fileUpload()">
                            <i class="icon-ok bigger-110"></i>
                            ADD
                        </button>
                    </div>

                </form>
            </div>

            <div class="span7">
                <div class="panel-group content-group-lg" id="accordion1">

                    @php $count = 1; @endphp
                    @forelse($get_course_lesson as $val)
                        @php
                            $open = '';
                            if (old('edit_title' . $val->id) != '' || old('edit_lesson_type' . $val->id) != '') {
                                $open = 'in';
                            }
                            $class = '';
                            if ($val->status == '0') {
                                $class = 'deactive';
                            }
                        @endphp
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion{{ $count }}"
                                        href="#accordion-group{{ $count }}"
                                        onclick="accordionClosed({{ $count }})"
                                        class="{{ $class }}">{{ $val->title }}</a>
                                </h6>
                                <a href="javascript:void(0)" onclick="delectLesson({{ $val->id }})"
                                    class="accordion1Delete"><i class="fa fa-trash"></i></a>
                            </div>

                            <div id="accordion-group{{ $count }}"
                                class="panel-collapse collapse {{ $open }}">
                                <div class="panel-body clearfix">
                                    <div class="span8">
                                        <form action="{{ url('admin/course/' . $val->id . '/update-course-lesson') }}"
                                            accept-charset="utf-8" method="post" class="form-horizontal"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="control-group">
                                                <label class="control-label">Title * </label>
                                                <div class="controls">
                                                    @php $title = old('edit_title'.$val->id) !="" ? old('edit_title'.$val->id) : $val->title @endphp
                                                    <input type="text" name="edit_title{{ $val->id }}"
                                                        id="edit_title{{ $val->id }}" class="form-control"
                                                        value="{{ $title }}" placeholder="Title">
                                                    <br />
                                                    @if ($errors->has('edit_title' . $val->id))
                                                        <strong>{{ $errors->first('edit_title' . $val->id) }}</strong>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label"
                                                    for="edit_lesson_type{{ $val->id }}">Lesson Type *</label>
                                                <div class="controls">
                                                    <select name="edit_lesson_type{{ $val->id }}"
                                                        id="edit_lesson_type{{ $val->id }}" class="form-control"
                                                        onchange="editAddLesson(this.value, {{ $val->id }})">
                                                        <option value="">Select Level</option>
                                                        @if (getLessonType() != '')
                                                            @php $lesson = old('edit_lesson_type'.$val->id) !="" ? old('edit_lesson_type'.$val->id) : strtolower($val->lesson_type) @endphp
                                                            @foreach (getLessonType() as $lessonType)
                                                                <option value="{{ strtolower($lessonType) }}"
                                                                    {{ strtolower($lesson) == strtolower($lessonType) ? 'selected' : '' }}>
                                                                    {{ $lessonType }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <br />
                                                    @if ($errors->has('edit_lesson_type' . $val->id))
                                                        <strong>{{ $errors->first('edit_lesson_type' . $val->id) }}</strong>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="control-group" id="file_box{{ $val->id }}">
                                                <label class="control-label" for="edit_file{{ $val->id }}"
                                                    id="file_txt{{ $val->id }}">{{ Str::ucfirst($val->lesson_type) }}</label>
                                                <div class="controls">
                                                    <input type="file" name="edit_file{{ $val->id }}"
                                                        id="edit_file{{ $val->id }}" class="form-control" />
                                                    @if ($errors->has('edit_file' . $val->id))
                                                        <strong>{{ $errors->first('edit_file' . $val->id) }}</strong>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label"
                                                    for="edit_file_pdf_text{{ $val->id }}">PDF/TEXT</label>
                                                <div class="controls">
                                                    <input type="file" name="edit_file_pdf_text{{ $val->id }}"
                                                        id="edit_file_pdf_text{{ $val->id }}"
                                                        class="form-control" />
                                                    @if ($errors->has('edit_file_pdf_text' . $val->id))
                                                        <strong>{{ $errors->first('edit_file_pdf_text' . $val->id) }}</strong>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="page">Status *</label>
                                                <div class="controls">
                                                    <select name="edit_status{{ $val->id }}"
                                                        id="edit_status{{ $val->id }}" class="form-control">
                                                        <option value="1"
                                                            {{ (old('edit_status') == '1' ? 'selected' : $val->status == '1') ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="0"
                                                            {{ (old('edit_status') == '0' ? 'selected' : $val->status == '0') ? 'selected' : '' }}>
                                                            Inactive</option>
                                                    </select>
                                                    @if ($errors->has(old('edit_status' . $val->id)))
                                                        <strong>{{ $errors->first(old('edit_status' . $val->id)) }}</strong>
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="hidden" value="{{ $val->id }}"
                                                name="edit_id{{ $val->id }}">
                                            <div class="control-group">
                                                <label class="control-label" for="page">&nbsp;</label>
                                                <div class="controls">
                                                    <button type="submit" name="submit" value="submit"
                                                        class="btn btn-info"
                                                        onclick="editFileUpload({{ $val->id }})">
                                                        <i class="icon-ok bigger-110"></i>
                                                        Update
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="span4 left-dot-border">
                                        <p class="previous_text">Previous files</p>
                                        @php
                                            $media = '';
                                            $pdf = '';
                                            if ($val->lesson_type == 'video'):
                                                $media = $val->video;
                                                $pdf = $val->text_pdf;
                                            elseif ($val->lesson_type == 'audio'):
                                                $media = $val->audio;
                                                $pdf = $val->text_pdf;
                                            elseif ($val->lesson_type == 'pdf'):
                                                $pdf = $val->text_pdf;
                                            endif;
                                        @endphp

                                        @if ($val->lesson_type == 'video' || $val->lesson_type == 'audio')
                                            <div class="control-group">
                                                <label class="control-label"
                                                    for="page"><b>{{ Str::ucfirst($val->lesson_type) }} : </b></label>
                                                <div class="controls">
                                                    <label>{{ $media }}</label>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($val->text_pdf != '')
                                            <div class="control-group">
                                                <label class="control-label" for="page"><b>PDF : </b></label>
                                                <div class="controls">
                                                    <label>{{ $pdf }}</label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $count++; @endphp
                    @empty
                        <p>No Lesson Found</p>
                    @endforelse
                </div>
                <!-- /basic accordion -->
            </div>
        </div>
        <!--/.span-->
    </div>
    <!--/.row-fluid-->

    <script>
        function addLesson(type) {
            let iStype = type.toLowerCase().trim();
            if (iStype == 'video') {
                $('#file_txt').html('Video');
                $('#file_box').show();
            } else if (iStype == 'audio') {
                $('#file_txt').html('Audio');
                $('#file_box').show();
            } else if (iStype == 'pdf') {
                $('#file_box').hide();
            }
        }

        function editAddLesson(type, id) {
            let iStype = type.toLowerCase().trim();
            if (iStype == 'video') {
                $('#file_txt' + id).html('Video');
                $('#file_box' + id).show();
            } else if (iStype == 'audio') {
                $('#file_txt' + id).html('Audio');
                $('#file_box' + id).show();
            } else if (iStype == 'pdf') {
                $('#file_box' + id).hide();
            }
        }

        function accordionClosed(id) {
            $('#accordion' + id).on('show.bs.collapse', function() {
                var $myGroup = $('#accordion' + id);
                $myGroup.find('.collapse.in').collapse('hide');
            });
        }

        function delectLesson(id) {
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
                            url: '{{ url('admin/course/destroy-course-lesson') }}',
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

        function editFileUpload(id) {
            console.log(id)
        }
    </script>

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

        #accordion1 .panel-heading h6.panel-title {
            margin: 0;
        }

        #accordion1 .panel-heading h6.panel-title a {
            border: 1px solid #ccc;
            padding: 10px 20px;
            display: block;
            color: #000;
        }

        #accordion1 .panel-heading {
            position: relative;
        }

        #accordion1 .panel-heading .accordion1Delete {
            position: absolute;
            right: 8px;
            top: 6px;
            background: red;
            width: 29px;
            text-align: center;
            padding: 5px 0;
            color: #fff;
            border-radius: 6px;
            font-size: 18px;
        }

        #accordion1 .panel-heading h6.panel-title a:hover {
            color: #2679b5;
            text-decoration: none;
        }

        #accordion1 .panel-body {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            margin-top: -1px;
        }

        .span4.left-dot-border {
            border-left: 1px dotted #ccc;
            padding-left: 6px
        }

        .previous_text {
            font-weight: bold;
            border-bottom: 1px solid #ccc;
        }

        .deactive {
            background: #ffdede;
        }

        @media (min-width: 769px) {
            .navbar {
                padding-left: 0px;
                padding-right: 0px;
            }
        }
    </style>

@endsection
