@extends('layouts.admin.layer')
@section('title', 'Add Security Question | Driving School')
@section('content')
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
            <li class="active">Security Question</li>
        </ul> 
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>Add Security Question</h1>
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
                <form accept-charset="utf-8" method="post" action="{{ url('admin/security/store-question') }}"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="control-group">
                        <label class="control-label" for="question">Question: *</label>
                        <div class="controls">
                            <textarea type="text" placeholder="Question" name="question" id="question" required>
                                {{ isset($data->question) ? $data->question : old('question') }}
                            </textarea>
                            @if ($errors->has('question'))
                                <strong>{{ $errors->first('question') }}</strong>
                            @endif
                        </div>
                    </div>
					
					<div class="control-group">
                        <label class="control-label" for="is_type">Is Type: *</label>
                        <div class="controls">
                            <select name="is_type" id="is_type">
                                <option value="">Select type</option>
                                @if (!blank(getQuestionBox()))
                                    @foreach (getQuestionBox() as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('is_type'))
                                <strong>{{ $errors->first('is_type') }}</strong>
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
                Results for "Security Question"
                <span class="text-muted pull-right show-count">Showing
                    {{ $records->currentPage() * $records->perPage() - $records->perPage() + 1 }} to
                    {{ $records->currentPage() * $records->perPage() > $records->total() ? $records->total() : $records->currentPage() * $records->perPage() }}
                    of {{ $records->total() }} data(s)</span>
            </div>

            <div class="search-box pull-right">
                <form action="{{ url('admin/security/add-question') }}" method="get">
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
                        <th class="hidden-480">Question</th>
						<th class="hidden-480">Type</th>
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
                            <td>{!! $val->question !!}</td>
							<td>{!! $val->is_type == 1
                                ? '<span class="badge badge-success">First Quetion Box</span>'
                                : '<span class="badge badge-info">Second Quetion Box</span>' !!}</td>
                            <td>{!! $val->status == 1
                                ? '<span class="badge badge-success">Active</span>'
                                : '<span class="badge badge-danger">Inactive</span>' !!}</td>
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
                            url: '{{ url('admin/security/destroy') }}',
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

        function editAddOn(id) {
            $.ajax({
                type: "POST",
                url: '{{ url('admin/security/edit') }}',
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
					
					var fType = '';
                    var SType = 'selected';
                    if (response.is_type == 1) {
                        fType = 'selected';
                        SType = '';
                    }

                    var html = '';
                    html += '<div class="col-md-12" id="update_form"><div class="control-group">' +
                        '<label class="control-label" for="form-field-1">Title :</label>' +
                        '<div class="controls">' +
                        '<textarea placeholder="Question" name="edit_question" id="edit_question" required>' +
                        response.question + '</textarea>' +
                        '</div>' +
                        '<input type="hidden" value="' + id + '" id="update_id">' +
                        '</div>' +
						'<div class="control-group">' +
                        '<label class="control-label" for="form-field-2">Is Type :</label>' +
                        '<div class="controls">' +
                        '<select class="status" name="edit_is_type" id="edit_is_type" required>';
                    html += '<option value="1" ' + fType + '>First Question Box</option>' +
                        '<option value="2" ' + SType + '>Second Question Box</option>';
                    html += '</select>' +
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
            var question = $('#edit_question').val();
			var is_type = $('#edit_is_type').val();
            var status = $('#edit_status').val();
            var id = $('#update_id').val();

            $('#edit_question').css('border', '1px solid #d5d5d5');
			$('#edit_is_type').css('border', '1px solid #d5d5d5');
            if (question == "") {
                $('#edit_question').css('border', '1px solid #ff0000');
                return false;
            } else if (is_type == "") {
                $('#edit_is_type').css('border', '1px solid #ff0000');
                return false;
            } else {
                var data = {
                    "id": id,
                    "question": question,
					"is_type": is_type,
                    "status": status,
                    "_token": "{{ csrf_token() }}"
                }
                $.ajax({
                    type: "POST",
                    url: '{{ url('admin/security/update') }}',
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
