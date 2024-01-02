@extends('layouts.admin.layer')
@section('title', 'Courses License | Driving School')
@section('content')
    <script src="{{ url('assets/admin/js/ckeditor/ckeditor.js') }}"></script>
    <div class="breadcrumbs" id="breadcrumbs">
        <script src="{{ url('assets/admin/js/bootbox.js') }}"></script>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="#">Home</a>

                <span class="divider">
                    <i class="icon-angle-right arrow-icon"></i>
                </span>
            </li>
            <li class="active">Courses License</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative clearfix">
            <div class="span10 header-title">
                <h1>Courses License</h1>
            </div>
            <div class="span3 btn-user">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#LicenseModal">
                    Import CSV
                </button>
            </div>
        </div>
        <!--/.page-header-->

        <div class="row-fluid">
            <div class="span12">

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

                <!--PAGE CONTENT BEGINS-->
                <form accept-charset="utf-8" method="post" action="{{ url('admin/license/store-license') }}"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="control-group">
                        <label class="control-label" for="license">License: *</label>
                        <div class="controls">
                            <input type="text" placeholder="License Number" name="license" id="license"
                                value="{{ isset($data->license) ? $data->title : old('license') }}" required>
                            @if ($errors->has('license'))
                                <strong>{{ $errors->first('license') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="submit" value="submit" class="btn btn-info">
                            <i class="icon-ok bigger-110"></i>
                            Add
                        </button>
                    </div>
                </form>
            </div>
            <!--PAGE CONTENT ENDS-->
        </div>
        <!--/.span-->

        <div class="row-fluid">
            <div class="table-header">
                Results for "Addon List"
                <span class="text-muted pull-right show-count">Showing
                    {{ $records->currentPage() * $records->perPage() - $records->perPage() + 1 }} to
                    {{ $records->currentPage() * $records->perPage() > $records->total() ? $records->total() : $records->currentPage() * $records->perPage() }}
                    of {{ $records->total() }} data(s)</span>
            </div>

            <div class="search-box pull-right">
                <form action="{{ url('admin/license/add-license') }}" method="get">
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
                        <th class="hidden-480">license Number</th>
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
                            <td>{!! $val->license !!}</td>
                            <td>{!! $val->status == 1
                                ? '<span class="badge badge-success">Active</span>'
                                : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                            <td>{{ $val->created_at }}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="editLicense({{ $val->id }})"><span
                                        class="badge badge-info"><i class="fa fa-pencil"></i></span></a>
                                <a href="javascript:void(0)" onclick="deleteData({{ $val->id }})"><span
                                        class="badge badge-danger"><i class="fa fa-trash"></i></span></a>
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

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="LicenseModal" tabindex="-1" role="dialog"
        aria-labelledby="questionModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/license/import-license-number') }}" method="post" accept-charset="utf-8"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="form-group">
                                    <label for="">CSV</label>
                                    @if ($errors->has('file'))
                                        <strong>{{ $errors->first('file') }}</strong>
                                    @endif
                                    <input type="file" name="file" id="file"
                                        class="form-control image-box" />
                                </div>
                            </div>

                            <div class="span12">
                                <div class="form-group">
                                    <button class="btn btn-primary">Import</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	
	<!-- Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog"
		aria-labelledby="questionModal" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="modal_body">
					
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
                            url: '{{ url('admin/license/destroy') }}',
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

        function editLicense(id) {
            $.ajax({
                type: "POST",
                url: '{{ url('admin/license/edit') }}',
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

                    var html = '';
                    html += '<div class="col-md-12" id="update_form"><div class="control-group">' +
                        '<label class="control-label" for="form-field-1">License :</label>' +
                        '<div class="controls">' +
                        '<input type="text" placeholder="License Number" name="edit_license" id="edit_license" value="' +
                        response.license + '" required>' +
                        '</div>' +
                        '<input type="hidden" value="' + id + '" id="update_id">' +
                        '</div>' +
                        '<div class="control-group">' +
                        '<label class="control-label" for="form-field-2">Status :</label>' +
                        '<div class="controls">' +
                        '<select class="status" name="edit_status" id="edit_status" required>';
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
            var license = $('#edit_license').val();
            var status = $('#edit_status').val();
            var id = $('#update_id').val();

            $('#edit_license').css('border', '1px solid #d5d5d5');
            if (license == "") {
                $('#edit_license').css('border', '1px solid #ff0000');
                return false;
            } else {
                var data = {
                    "id": id,
                    "license": license,
                    "status": status,
                    "_token": "{{ csrf_token() }}"
                }
                $.ajax({
                    type: "POST",
                    url: '{{ url('admin/license/update') }}',
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
