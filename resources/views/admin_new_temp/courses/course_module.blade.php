@extends('layouts.admin.layer')
@section('title', 'Courses Module | Driving School')
@section('content')
    <script src="{{ url('assets/admin/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ url('assets/admin/js/bootbox.js') }}"></script>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Courses Module Lists</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Courses Module</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="control-group">
                        <!-- Message here -->
                        @if (!empty(Session::get('message')) && isset(Session::get('message')['status']) == '1')
                            <div class="control-group">
                                <div class="alert alert-success inline">
                                    {{ Session::get('message')['text'] }}
                                </div>
                            </div>
                        @elseif (!empty(Session::get('message')) && isset(Session::get('message')['status']) == '0')
                            <div class="control-group">
                                <div class="alert alert-danger inline">
                                    {{ Session::get('message')['text'] }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!--PAGE CONTENT BEGINS-->
                    <form accept-charset="utf-8" method="post" action="{{ url('admin/course/store-course-module') }}"
                        class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="title" class="form-label">Name : *</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Name" name="name" id="name"
                                    value="{{ old('name') ? old('name') : '' }}" class="form-control">
                                @if ($errors->has('name'))
                                    <strong>{{ $errors->first('name') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="title" class="form-label">Description : </label>
                            </div>
                            <div class="col-lg-6">
                                <textarea type="text" placeholder="Name" name="description" id="description" class="form-control">{{ old('description') ? old('description') : '' }}</textarea>
                                @if ($errors->has('description'))
                                    <strong>{{ $errors->first('description') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="title" class="form-label">Duration : </label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Duration" name="duration" id="duration"
                                    value="{{ old('duration') ? old('duration') : '' }}" class="form-control">
                                @if ($errors->has('duration'))
                                    <strong>{{ $errors->first('duration') }}</strong>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="courses_id" value="{{ $id }}">

                        <div class="row mb-3">
                            <div class="col-lg-2 custom-text-align">
                                <label for="status" class="form-label">&nbsp; </label>
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
                            <form action="{{ url('admin/course/' . $id . '/course-module-add') }}" method="get">
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
                                        <th class="hidden-480">Name</th>
                                        <th class="hidden-480">Description</th>
                                        <th class="hidden-480">Duration</th>
                                        <th class="hidden-480">status</th>
                                        <th class="hidden-480">Sort</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @forelse($records as $val)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{!! $val->name !!}</td>
                                            <td>{!! $val->description !!}</td>
                                            <td>{!! $val->duration !!}</td>
                                            <td>{!! $val->status == 1
                                                ? '<span class="badge bg-success">Active</span>'
                                                : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                                            <td>
                                                <input type="text" id="sort_{{ $val->id }}" class="nav-sort"
                                                    value="{{ $val->sort }}" onchange="sort({{ $val->id }})">
                                            </td>
                                            <td>{{ $val->created_at }}</td>
                                            <td>
                                                <a href="javascript:void(0)"
                                                    onclick="editModule({{ $val->id }})"><span
                                                        class="badge bg-info"><i class="ri-edit-2-line"></i></span></a>
                                                <a href="javascript:void(0)"
                                                    onclick="deleteData({{ $val->id }})"><span
                                                        class="badge bg-danger"><i
                                                            class="ri-delete-bin-line"></i></span></a>
                                                <a class="badge bg-warning"
                                                    href="{{ url('admin/course/' . $val->courses_id . '/' . $val->id . '/course-lesson-add') }}">Go
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

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="control-group" id="error-box"></div>
                    <div id="modal_body"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="update()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!--/.row-fluid-->
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
                            url: '{{ url('admin/course/destroy-course-module') }}',
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

        function sort(id) {
            var sortVal = $('#sort_' + id).val() != "" ? $('#sort_' + id).val() : 0;
            $.ajax({
                type: "POST",
                url: '{{ url('admin/course/set-module-sort') }}',
                data: {
                    "id": id,
                    "sortVal": sortVal,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    if (response.status == 2) {
                        toastr.error(response.text);
                    } else if (response.status == 1) {
                        toastr.success(response.text);
                    } else {
                        toastr.error(response.text);
                    }
                }
            });
        }

        function editModule(id) {
            $.ajax({
                type: "POST",
                url: '{{ url('admin/course/courses-module-edit') }}',
                data: {
                    "id": id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(response) {
                    var aStatus = '';
                    var iStatus = 'selected';
                    if (response.status == 1) {
                        aStatus = 'selected';
                        iStatus = '';
                    }

                    var description = response.description != undefined ? response.description : '';
                    var duration = response.duration != undefined ? response.duration : '';

                    var html = '';
                    html += '<div class="col-md-12" id="update_form"><div class="control-group">' +
                        '<label class="control-label" for="form-field-1">Title :</label>' +
                        '<div class="controls">' +
                        '<input type="text" placeholder="Name" class="form-control" name="edit_name" id="edit_name" value="' +
                        response.name + '" required>' +
                        '</div>' +
                        '<input type="hidden" value="' + id + '" id="update_id">' +
                        '</div>' +
                        '<div class="control-group">' +
                        '<label class="control-label" for="form-field-1">Description :</label>' +
                        '<div class="controls">' +
                        '<input type="text" placeholder="Description" class="form-control" name="edit_description" id="edit_description" value="' +
                        description + '" required>' +
                        '</div>' +
                        '</div>' +
                        '<div class="control-group">' +
                        '<label class="control-label" for="form-field-1">Duration :</label>' +
                        '<div class="controls">' +
                        '<input type="text" placeholder="Duration" class="form-control" name="edit_duration" id="edit_duration" value="' +
                        duration + '" required>' +
                        '</div>' +
                        '</div>' +
                        '<div class="control-group">' +
                        '<label class="control-label" for="form-field-2">Status :</label>' +
                        '<div class="controls">' +
                        '<select class="form-control" name="edit_status" id="edit_status" required>';
                    html += '<option value="0" ' + iStatus + '>Inactive</option>' +
                        '<option value="1" ' + aStatus + '>Active</option>';
                    html += '</select>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    $('#modal_body').html(html);
                    $('#editModal').modal('show');
                }
            });
        }

        function update() {
            var name = $('#edit_name').val();
            var description = $('#edit_description').val();
            var duration = $('#edit_duration').val();
            var status = $('#edit_status').val();
            var id = $('#update_id').val();

            $('#edit_name').css('border', '1px solid #d5d5d5');

            if (name == "") {
                $('#edit_name').css('border', '1px solid #ff0000');
                return false;
            } else {
                var data = {
                    "id": id,
                    "name": name,
                    "description": description,
                    "duration": duration,
                    "status": status,
                    "_token": "{{ csrf_token() }}"
                }
                $.ajax({
                    type: "POST",
                    url: '{{ url('admin/course/courses-module-update') }}',
                    data: data,
                    success: function(response) {
                        $('#error-box').html('');
                        if (response.status == 0) {
                            $('#error-box').html('<div class="alert alert-danger">' + response.text + '</div');
                        } else if (response.status == 1) {
                            $('#error-box').html('<div class="alert alert-success">' + response.text + '</div');
                            location.reload();
                        } else {
                            $('#error-box').html('<div class="alert alert-danger">Something is worng.</div>');
                        }
                    }
                });
            }
        }
    </script>
@endsection
