@extends('layouts.admin.layer')
@section('title', 'Addon Amount | Driving School')
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
            <li class="active">Addon Amount</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>Addon Amount</h1>
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
                <form accept-charset="utf-8" method="post" action="{{ url('admin/addon/store-addon') }}"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="control-group">
                        <label class="control-label" for="title">Title: *</label>
                        <div class="controls">
                            <input type="text" placeholder="Title" name="title" id="title"
                                value="{{ isset($data->title) ? $data->title : old('title') }}" required>
                            @if ($errors->has('title'))
                                <strong>{{ $errors->first('title') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="title">Amount: *</label>
                        <div class="controls">
                            <input type="number" placeholder="Amount" name="amount" id="amount"
                                value="{{ isset($data->title) ? $data->title : old('amount') }}" step="0.1" required>
                            @if ($errors->has('amount'))
                                <strong>{{ $errors->first('amount') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="title">Is Type: *</label>
                        <div class="controls">
                            <select name="is_addons" id="is_addons">
                                @if (!blank(getAddons()))
                                    @foreach (getAddons() as $key => $addon)
                                        <option value="{{ $key }}">{{ $addon }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('is_addons'))
                                <strong>{{ $errors->first('is_addons') }}</strong>
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
                <form action="{{ url('admin/addon/add-addon') }}" method="get">
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
                        <th class="hidden-480">Name</th>
                        <th class="hidden-480">Amount</th>
                        <th class="hidden-480">Is Type</th>
                        <th class="hidden-480">status</th>
                        <th class="hidden-480">Sort</th>
                        <th>Created at</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @php $count = 1; @endphp
                    @forelse($records as $val)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{!! $val->name !!}</td>
                            <td>{{ $val->amount }}</td>
                            <td>
                                @if ($val->is_type == '1')
                                    <span class="badge badge-info">Addons</span>
                                @elseif ($val->is_type == '2')
                                    <span class="badge badge-info">Certificate</span>
                                @endif
                            </td>
                            <td>{!! $val->status == 1
                                ? '<span class="badge badge-success">Active</span>'
                                : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                            <td>
                                <input type="text" id="sort_{{ $val->id }}" class="nav-sort"
                                    value="{{ $val->sort }}" onchange="sort({{ $val->id }})">
                            </td>
                            <td>{{ $val->created_at }}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="editAddOn({{ $val->id }})"><span
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
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
                    <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                            url: '{{ url('admin/addon/destroy') }}',
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
                url: '{{ url('admin/addon/sort') }}',
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

        function editAddOn(id) {
            $.ajax({
                type: "POST",
                url: '{{ url('admin/addon/edit') }}',
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
                        '<label class="control-label" for="form-field-1">Title :</label>' +
                        '<div class="controls">' +
                        '<input type="text" placeholder="Title" name="edit_title" id="edit_title" value="' +
                        response.name + '" required>' +
                        '</div>' +
                        '<input type="hidden" value="' + id + '" id="update_id">' +
                        '</div>' +
                        '<div class="col-md-12" id="update_form"><div class="control-group">' +
                        '<label class="control-label" for="form-field-1">Title :</label>' +
                        '<div class="controls">' +
                        '<input type="number" placeholder="Amount" name="edit_amount" value="' +
                        response.amount + '" id="edit_amount" step="0.1" required>' +
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
            var title = $('#edit_title').val();
            var amount = $('#edit_amount').val();
            var status = $('#edit_status').val();
            var id = $('#update_id').val();

            $('#edit_title').css('border', '1px solid #d5d5d5');
            $('#edit_amount').css('border', '1px solid #d5d5d5');

            if (title == "") {
                $('#edit_title').css('border', '1px solid #ff0000');
                return false;
            } else if (amount == "") {
                $('#edit_amount').css('border', '1px solid #ff0000');
                return false;
            } else {
                var data = {
                    "id": id,
                    "title": title,
                    "amount": amount,
                    "status": status,
                    "_token": "{{ csrf_token() }}"
                }
                $.ajax({
                    type: "POST",
                    url: '{{ url('admin/addon/update') }}',
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
