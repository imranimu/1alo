@extends('layouts.admin.layer')
@section('title', 'Course Add | Driving School')
@section('content')
    <script src="{{ url('assets/admin/js/bootbox.js') }}"></script>
    <script src="{{ url('assets/admin/js/ckeditor/ckeditor.js') }}"></script>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Course Add</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Course Add</h4>
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
                    <form action="{{ route('admin.course.store-course') }}" accept-charset="utf-8" method="post"
                        class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="title" class="form-label">Title *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Title" name="title" id="title"
                                    value="{{ old('title') }}" onchange="makeSlug(this.value)" class="form-control">
                                @if ($errors->has('title'))
                                    <strong>{{ $errors->first('title') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="slug" class="form-label">Slug *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Slug" name="slug" id="slug"
                                    value="{{ old('slug') }}" class="form-control" readonly>
                                @if ($errors->has('slug'))
                                    <strong>{{ $errors->first('slug') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="duration" class="form-label">Duration *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" placeholder="Duration" name="duration" id="duration"
                                    value="{{ old('duration') }}" maxlength="6" step="0.1" class="form-control">
                                @if ($errors->has('duration'))
                                    <strong>{{ $errors->first('duration') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="nameInput" class="form-label">Price *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" placeholder="Price" name="price" id="price"
                                    value="{{ old('price') }}" maxlength="8" step="0.1" class="form-control">
                                @if ($errors->has('price'))
                                    <strong>{{ $errors->first('price') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="description" class="form-label">Description *</label>
                            </div>
                            <div class="col-lg-10">
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <strong>{{ $errors->first('description') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="description" class="form-label">Discussion </label>
                            </div>
                            <div class="col-lg-10">
                                <textarea name="discussion" id="discussion" class="form-control">{{ old('discussion') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="description" class="form-label">Image </label>
                            </div>
                            <div class="col-lg-10">
                                <input type="file" name="image" id="image" class="form-control" />
                                @if ($errors->has('image'))
                                    <strong>{{ $errors->first('image') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="status" class="form-label">Status </label>
                            </div>
                            <div class="col-lg-4">
                                <select class="form-select" data-choices="" data-choices-sorting="true" name="status">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @if ($errors->has('status'))
                                    <strong>{{ $errors->first('status') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="status" class="form-label">&nbsp; </label>
                            </div>
                            <div class="col-lg-4">
                                <button type="submit" name="submit" value="submit" class="btn btn-info">
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
    <style>
        .custom-text-align {
            text-align: right;
            line-height: 30px;
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
