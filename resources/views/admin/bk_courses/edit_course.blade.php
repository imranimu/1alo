@extends('layouts.admin.layer')
@section('title', 'Edit Course | Driving School')
@section('content')
    <script src="{{ url('assets/admin/js/bootbox.js') }}"></script>
    <script src="{{ url('assets/admin/js/ckeditor/ckeditor.js') }}"></script>
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="#">Home</a>

                <span class="divider">
                    <i class="icon-angle-right arrow-icon"></i>
                </span>
            </li>
            <li class="active">Edit Course</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>Edit Course</h1>
        </div>
        <!--/.page-header-->
        <div class="row-fluid">
            <div class="span12">
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
                <form action="{{ url('admin/course/' . $id . '/update') }}" accept-charset="utf-8" method="post"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Title *</label>
                        <div class="controls">
                            @php $title = old('title') !="" ? old('title') : $get_course->title !="" ? $get_course->title : '' @endphp
                            <input type="text" placeholder="Title" name="title" id="title"
                                value="{{ $title }}" onchange="makeSlug(this.value)" class="form-control">
                            @if ($errors->has('title'))
                                <strong>{{ $errors->first('title') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Slug *</label>
                        <div class="controls">
                            @php $slug = old('slug') !="" ? old('slug') : $get_course->slug !="" ? $get_course->slug : '' @endphp
                            <input type="text" placeholder="Slug" name="slug" id="slug"
                                value="{{ $slug }}" class="form-control">
                            @if ($errors->has('slug'))
                                <strong>{{ $errors->first('slug') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Level *</label>
                        <div class="controls">
                            <select name="level" id="level" class="form-control">
                                <option value="">Select Level</option>
                                @if (getCourseLevel() != '')
                                    @php $level = old('level') !="" ? old('level') : $get_course->course_level !="" ? $get_course->course_level : '' @endphp
                                    @foreach (getCourseLevel() as $val)
                                        <option value="{{ $val }}" {{ $level == $val ? 'selected' : '' }}>
                                            {{ $val }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('level'))
                                <strong>{{ $errors->first('level') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Duration *</label>
                        <div class="controls">
                            @php $duration = old('duration') !="" ? old('duration') : $get_course->course_duration !="" ? $get_course->course_duration : '' @endphp
                            <input type="number" placeholder="Duration" name="duration" id="duration"
                                value="{{ $duration }}" maxlength="6" step="0.1" class="form-control">
                            @if ($errors->has('duration'))
                                <strong>{{ $errors->first('duration') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Price *</label>
                        <div class="controls">
                            @php $price = old('price') !="" ? old('price') : $get_course->price !="" ? $get_course->price : '' @endphp
                            <input type="number" placeholder="Price" name="price" id="price"
                                value="{{ $price }}" maxlength="8" step="0.1" class="form-control">
                            @if ($errors->has('price'))
                                <strong>{{ $errors->first('price') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Description</label>
                        <div class="controls">
                            @php $description = old('description') !="" ? old('description') : $get_course->description !="" ? $get_course->description : '' @endphp
                            <textarea name="description" id="description" class="form-control">{{ $description }}</textarea>
                            @if ($errors->has('description'))
                                <strong>{{ $errors->first('description') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Discussion</label>
                        <div class="controls">
                            @php $discussion = old('discussion') !="" ? old('discussion') : $get_course->discussions !="" ? $get_course->discussions : '' @endphp
                            <textarea name="discussion" id="discussion" class="form-control">{{ $discussion }}</textarea>
                            @if ($errors->has('discussion'))
                                <strong>{{ $errors->first('discussion') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Image</label>
                        <div class="controls">
                            <input type="file" name="image" id="image" class="form-control" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="page">Status *</label>
                        <div class="controls">
                            <select name="status" id="status" class="form-control">
                                <option value="1"
                                    {{ (old('status') == '1' ? 'selected' : $get_course->status == '1') ? 'selected' : '' }}>
                                    Active</option>
                                <option value="0"
                                    {{ (old('status') == '0' ? 'selected' : $get_course->status == '0') ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                            @if ($errors->has('status'))
                                <strong>{{ $errors->first('status') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Previous Image</label>
                        <div class="controls">
                            @if ($get_course->image != '')
                                <img src="{{ asset('storage/image/course/thumbnail/' . $get_course->image) }}"
                                    alt="" class="image-list" style="width: 15%;">
                            @endif
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="submit" value="submit" class="btn btn-info">
                            <i class="icon-ok bigger-110"></i>
                            ADD
                        </button>
                    </div>

                </form>

            </div>
            <!--PAGE CONTENT ENDS-->
        </div>
        <!--/.span-->
    </div>
    <!--/.row-fluid-->
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
    </style>
    <script>
        function makeSlug(value) {
            const str = value.trim().replace(/[^a-zA-Z ]/g, "");
            const slug = str.replace(/\s/g, '-');;
            $('#slug').val(slug.toLowerCase());
        }

        CKEDITOR.replace('description');
        CKEDITOR.replace('discussion');
    </script>
@endsection
