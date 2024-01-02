@extends('layouts.admin.layer')

@section('title', 'Exam Lists | Driving School')

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
                        <li class="breadcrumb-item active">Exam Lists</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="clo-md-12 d-flex">
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-bs-toggle="modal"
                data-bs-target="#questionModal">
                Add New
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Exam Lists</h4>
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
                            <form action="{{ url('admin/question/exam-show') }}" method="get">
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
                                        <th class="hidden-480">title</th>
                                        <th class="hidden-480">Courses Name</th>
                                        <th class="hidden-480">Module Name</th>
                                        <th class="hidden-480">Limit Number</th>
                                        <th class="hidden-480">Status</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @forelse($records as $val)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $val->title }}</td>
                                            <td>{{ getCourseName($val->courses_id) }}</td>
                                            <td>{{ !blank($val->get_module) ? $val->get_module->name : '' }}</td>
                                            <td><input type="input" name="limit_number" id="limit_number"
                                                    class="from-control" value="{{ $val->limit_number }}"
                                                    onchange="limitNumber(this.value, {{ $val->id }})"
                                                    style="max-width: 40px;" />
                                            </td>
                                            <td>{!! $val->status == 1
                                                ? '<span class="badge bg-success">Active</span>'
                                                : '<span class="badge bg-danger">Inactive</span>' !!}</td>

                                            <td>{{ $val->created_at }}</td>
                                            <td>
                                                <a class="badge bg-info"
                                                    href="{{ url('admin/question/exam/' . $val->id . '/edit') }}"
                                                    data-toggle="tooltip" title="Edit">
                                                    <i class="ri-edit-2-line"></i>
                                                </a>
                                                <a class="badge bg-danger trash" href="javascript:void(0)"
                                                    onclick="examDelete({{ $val->id }})" data-toggle="tooltip"
                                                    title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                                <a class="badge bg-warning"
                                                    href="{{ url('/admin/question/show/' . $val->id) }}"
                                                    data-toggle="tooltip" title="Change Password">
                                                    Add Question <i class="ri-arrow-right-fill"></i></a>
                                                </a>
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
    <!-- end row -->

    <!-- Modal -->
    <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/question/store-exam') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for=""><strong>Enter title</strong></label>
                            @if ($errors->has('title'))
                                <strong>{{ $errors->first('title') }}</strong>
                            @endif
                            <input type="text" required="required" name="title" placeholder="Enter title"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for=""><strong>Select course</strong></label>
                            @if ($errors->has('exam_category'))
                                <strong>{{ $errors->first('exam_category') }}</strong>
                            @endif
                            <select class="form-control" required="required" name="exam_courses"
                                onchange="getModule(this.value)">
                                <option value="">Select</option>
                                @if (!blank($getCourses))
                                    @foreach ($getCourses as $val)
                                        <option value="{{ $val->id }}">{{ $val->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for=""><strong>Select module</strong></label>
                            @if ($errors->has('exam_category'))
                                <strong>{{ $errors->first('exam_category') }}</strong>
                            @endif
                            <select class="form-control" required="required" name="exam_module" id="exam_module">
                                <option value="">Select</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary mt-2">Add</button>
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

        function limitNumber(val, id) {
            let limit_val = val;
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/question/set-limit-number') }}',
                data: {
                    "id": id,
                    "limit_val": limit_val,
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
