@extends('layouts.admin.layer')
@section('title', 'Document Add | Driving School')
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
                        <li class="breadcrumb-item active">Document Add</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Document Add</h4>
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
                    <form action="{{ route('admin.document.store') }}" accept-charset="utf-8" method="post"
                        class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="question" class="form-label">Course *</label>
                            </div>
                            <div class="col-lg-6">
                                <select name="course_id" id="course_id" class="form-control">
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

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="question" class="form-label">Title </label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Title" name="title" id="title"
                                    value="{{ old('title') }}" class="form-control">
                                @if ($errors->has('title'))
                                    <strong>{{ $errors->first('title') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="question" class="form-label">File</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="file" name="file_upload" id="file_upload" class="form-control" />
                                @if ($errors->has('file_upload'))
                                    <strong>{{ $errors->first('file_upload') }}</strong>
                                @endif
                                <br>
                                <strong>Ex. PDF, PNG, JPG (Max size: 5MB)</strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="question" class="form-label">Status </label>
                            </div>
                            <div class="col-lg-6">
                                <select name="status" id="status1" class="form-control">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
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

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Document Lists</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <span class="text-muted pull-right show-count">Showing
                                {{ $records->currentPage() * $records->perPage() - $records->perPage() + 1 }} to
                                {{ $records->currentPage() * $records->perPage() > $records->total() ? $records->total() : $records->currentPage() * $records->perPage() }}
                                of {{ $records->total() }} data(s)</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <form action="{{ url('admin/document/show') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" name="q"
                                        value="{{ Request::get('q') }}">
                                    <button class="btn btn-primary" type="Submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table table-striped table-nowrap table-bordered align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="hidden-480">ID</th>
                                        <th class="hidden-480">Courses Name</th>
                                        <th class="hidden-480">Title</th>
                                        <th class="hidden-480">file</th>
                                        <th class="hidden-480">sort</th>
                                        <th class="hidden-480">status</th>
                                        <th>Created at</th>
                                        <th>Action</th>
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
                                                    class="badge bg-primary">Download</a>
                                            </td>
                                            <td><input type="number" value="{{ $val->sort }}" name="sort"
                                                    id="sort" onchange="sort(this.value, {{ $val->id }})"
                                                    style="max-width: 40px;"></td>
                                            <td>{!! $val->status == '1'
                                                ? '<span class="badge bg-success">Active</span>'
                                                : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                                            <td>{{ $val->created_at }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="badge bg-danger"
                                                    onclick="deleteData({{ $val->id }})"><i
                                                        class="ri-delete-bin-line"></i></a>
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
                        </div>
                    </div>

                    <div class="mt-3">
                        @if ($records->lastPage() > 1)

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">

                                    @if ($records->currentPage() != 1 && $records->lastPage() >= 5)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $records->url($records->url(1)) }}">
                                                ← &nbsp; Prev </a>
                                        </li>
                                    @endif

                                    @if ($records->currentPage() != 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $records->url($records->currentPage() - 1) }}">
                                                < </a>
                                        </li>
                                    @endif

                                    @for ($i = max($records->currentPage() - 2, 1); $i <= min(max($records->currentPage() - 2, 1) + 4, $records->lastPage()); $i++)
                                        <li class="page-item {{ $records->currentPage() == $i ? ' active' : '' }}">
                                            <a class="page-link" href="{{ $records->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    @if ($records->currentPage() != $records->lastPage())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $records->url($records->currentPage() + 1) }}">
                                                >
                                            </a>
                                        </li>
                                    @endif

                                    @if ($records->currentPage() != $records->lastPage() && $records->lastPage() >= 5)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $records->url($records->lastPage()) }}">
                                                Next &nbsp; →
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
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
