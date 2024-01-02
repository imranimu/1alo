@extends('layouts.admin.layer')
@section('title', 'Document Add | Driving School')
@section('content')
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
            <li class="active">Document Add</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>Document Add</h1>
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
                <form action="{{ route('admin.document.store') }}" accept-charset="utf-8" method="post"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Course *</label>
                        <div class="controls">
                            <select name="course_id" id="course_id">
                                <option value="">Select</option>
                                <option value="0">All</option>
                                @if (!blank($getCourse))
                                    @foreach ($getCourse as $val)
                                        <option value="{{ $val->id }}">{{ $val->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('course_id'))
                                <strong>{{ $errors->first('course_id') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Title *</label>
                        <div class="controls">
                            <input type="text" placeholder="Title" name="title" id="title"
                                value="{{ old('title') }}" class="form-control">
                            @if ($errors->has('title'))
                                <strong>{{ $errors->first('title') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="form-field-1">File</label>
                        <div class="controls">
                            <input type="file" name="file_upload" id="file_upload" class="form-control" />
                            @if ($errors->has('file_upload'))
                                <strong>{{ $errors->first('file_upload') }}</strong>
                            @endif
                            <br>
                            <strong>Ex. PDF, PNG, JPG (Max size: 5MB)</strong>
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

        <div class="row-fluid">
            <div class="table-header">
                Results for "Document Lists"
                <span class="text-muted pull-right show-count">Showing
                    {{ $records->currentPage() * $records->perPage() - $records->perPage() + 1 }} to
                    {{ $records->currentPage() * $records->perPage() > $records->total() ? $records->total() : $records->currentPage() * $records->perPage() }}
                    of {{ $records->total() }} data(s)</span>
            </div>

            <div class="search-box pull-right">
                <form action="{{ url('admin/content/show') }}" method="get">
                    <div class="control-group">
                        <input type="text" class="from-control search-input-nav" placeholder="Search" name="q"
                            value="{{ Request::get('q') }}">
                        <input type="submit" value="Search" class="search-btn">
                    </div>
                </form>
            </div>

            <table id="sample-table-2" class="table table-striped table-bordered table-hover notice-table">
                <thead>
                    <tr>
                        <th class="hidden-480">ID</th>
                        <th class="hidden-480">Courses Name</th>
                        <th class="hidden-480">Title</th>
                        <th class="hidden-480">file</th>
                        <th class="hidden-480">sort</th>
                        <th class="hidden-480">status</th>
                        <th>Created at</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @php $count = 1; @endphp
                    @forelse($records as $val)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>
                                @if ($val->course_id > 0)
                                    {{ getCourseName($val->course_id) }}
                                @else
                                    All
                                @endif
                            </td>
                            <td>{{ $val->title }}</td>
                            <td>
                                <a href="{{ asset('storage/document/' . $val->file) }}" target="_blank"
                                    class="badge badge-primary">Download</a>
                            </td>
                            <td><input type="number" value="{{ $val->sort }}" name="sort" id="sort"
                                    onchange="sort(this.value, {{ $val->id }})" style="max-width: 40px;"></td>
                            <td>{!! $val->status == '1'
                                ? '<span class="badge badge-success">Active</span>'
                                : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                            <td>{{ $val->created_at }}</td>
                            <td>
                                <a href="javascript:void(0)" class="badge badge-danger"
                                    onclick="deleteData({{ $val->id }})"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @php $count++ @endphp
                    @empty
                        <tr>
                            <td colspan="7">No Data Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($records->lastPage() > 1)
                <ul class="pager">

                    @if ($records->currentPage() != 1 && $records->lastPage() >= 5)
                        <li class="previous">
                            <a href="{{ $records->url($records->url(1)) }}">
                                << </a>
                        </li>
                        @endif @if ($records->currentPage() != 1)
                            <li class="previous">
                                <a href="{{ $records->url($records->currentPage() - 1) }}">
                                    < </a>
                            </li>
                            @endif @for ($i = max($records->currentPage() - 2, 1); $i <= min(max($records->currentPage() - 2, 1) + 4, $records->lastPage()); $i++)
                                <li class="{{ $records->currentPage() == $i ? ' active' : '' }}">
                                    <a href="{{ $records->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($records->currentPage() != $records->lastPage())
                                <li>
                                    <a href="{{ $records->url($records->currentPage() + 1) }}">
                                        >
                                    </a>
                                </li>
                            @endif

                            @if ($records->currentPage() != $records->lastPage() && $records->lastPage() >= 5)
                                <li>
                                    <a href="{{ $records->url($records->lastPage()) }}">
                                        >>
                                    </a>
                                </li>
                            @endif
                </ul>
            @endif
        </div>
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
        function deleteData(id) {
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
                            url: '{{ url('admin/document/destroy') }}',
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

        function sort(val, id) {
            let sort_val = val;
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/document/set-sort') }}',
                data: {
                    "id": id,
                    "sort_val": sort_val,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
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
                },
                error: function(response) {
                    toastr.error(response.text)
                }
            });
        }
    </script>
@endsection
