@extends('layouts.admin.layer')
@section('title', 'Course Add | Driving School')
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
                        <li class="breadcrumb-item active">Course Lists</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Course Lists</h4>
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
                            <form action="{{ url('admin/course/course-lists') }}" method="get">
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
                                        <th class="hidden-480">Image</th>
                                        <th class="hidden-480">Title</th>
                                        <th class="hidden-480">Slug</th>
                                        <th class="hidden-480">Duration</th>
                                        <th class="hidden-480">price</th>
                                        <th class="hidden-480">status</th>
                                        <th>Sort</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @forelse($records as $val)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td width="200px">
                                                @if ($val->image != '')
                                                    <img src="{{ asset('storage/app/public/image/course/thumbnail/' . $val->image) }}"
                                                        alt="" style="height: 40px;" class="image-list">
                                                @endif
                                            </td>
                                            <td>{{ $val->title }}</td>
                                            <td>{{ $val->slug }}</td>
                                            <td>{{ $val->course_duration }}</td>
                                            <td>{{ $val->price }}</td>
                                            <td>{!! $val->status == 1
                                                ? '<span class="badge bg-success">Active</span>'
                                                : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                                            <td><input type="input" name="sort" id="sort" class="from-control"
                                                    value="{{ $val->sort }}"
                                                    onchange="sort(this.value, {{ $val->id }})"
                                                    style="max-width: 40px;" /></td>
                                            <td>{{ $val->created_at }}</td>
                                            <td>
                                                <a class="badge bg-success"
                                                    href="{{ url('admin/course/' . $val->id . '/edit') }}"><i
                                                        class="ri-edit-2-line"></i></a>

                                                <a class="badge bg-danger" href="javascript:void(0)"
                                                    onclick="deleteData({{ $val->id }})"><i
                                                        class="ri-delete-bin-line"></i></a>

                                                <a class="badge text-bg-warning"
                                                    href="{{ url('admin/course/' . $val->id . '/course-module-add') }}">Go
                                                    To
                                                    Course Module <i class="ri-arrow-right-fill"></i></a>

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
                            url: '{{ url('admin/course/destroy-course') }}',
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
                url: '{{ url('admin/course/set-sort') }}',
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

    <style>
        table.table td {
            vertical-align: middle;
        }
    </style>

@endsection
