@extends('layouts.admin.layer')

@section('title', 'Question Lists | Driving School')

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
            <li class="active">Question Lists</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative clearfix">
            <div class="span10 header-title">
                <h1>Question Lists</h1>
            </div>
            <div class="span3 btn-user">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#questionModal">
                    Add New
                </button>
            </div>
        </div>
        <!--/.page-header-->

        <div class="row-fluid">
            <div class="table-header">
                Results for "Question Lists"
                <span class="text-muted pull-right show-count">Showing
                    {{ $records->currentPage() * $records->perPage() - $records->perPage() + 1 }} to
                    {{ $records->currentPage() * $records->perPage() > $records->total() ? $records->total() : $records->currentPage() * $records->perPage() }}
                    of {{ $records->total() }} data(s)</span>
            </div>

            <div class="search-box pull-right">
                <form action="{{ url('admin/employee-details') }}" method="get">
                    <div class="control-group">
                        <input type="text" class="from-control search-input-nav" placeholder="Search" name="q"
                            value="{{ Request::get('q') }}">
                        <input type="submit" value="Search" class="search-btn">
                    </div>
                </form>
            </div>

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

            <table id="sample-table-2" class="table table-striped table-bordered table-hover notice-table">
                <thead>
                    <tr>
                        <th class="hidden-480">ID</th>
                        <th class="hidden-480">Question</th>
                        <th class="hidden-480">Ans</th>
                        <th class="hidden-480">Status</th>
                        <th>Created at</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @php $count = 1; @endphp
                    @forelse($records as $val)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $val->question }}</td>
                            <td>{{ $val->ans }}</td>
                            <td>{!! $val->status == 1
                                ? '<span class="badge badge-success">Active</span>'
                                : '<span class="badge badge-danger">Inactive</span>' !!}</td>

                            <td>{{ $val->created_at }}</td>
                            <td>
                                <a class="badge badge-info" href="{{ url('admin/question/' . $val->id . '/edit') }}"
                                    data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="badge badge-danger trash" href="javascript:void(0)"
                                    onclick="questionDelete({{ $val->id }})" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-trash"></i>
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

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="questionModal" tabindex="-1" role="dialog"
        aria-labelledby="questionModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/question/store-question') }}" method="post"  accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="form-group">
                                    <label for="">Question</label>
                                    <input type="hidden" name="exam_id" value="{{ $id }}">
                                    @if ($errors->has('question'))
                                        <strong>{{ $errors->first('question') }}</strong>
                                    @endif
                                    @if ($errors->has('exam_id'))
                                        <strong>{{ $errors->first('exam_id') }}</strong>
                                    @endif
                                    <input type="text" required="required" name="question" placeholder="Enter Question"
                                        class="form-control" value="{{ old('question') }}">
                                </div>
                            </div>

                            <div class="span5">
                                <div class="form-group">
                                    <label for="">Option 1</label>
                                    @if ($errors->has('option_1'))
                                        <strong>{{ $errors->first('option_1') }}</strong>
                                    @endif
                                    <input type="text" required="required" name="option_1"
                                        placeholder="Enter Question" class="form-control" value="{{ old('option_1') }}">
                                </div>
                            </div>

                            <div class="span5">
                                <div class="form-group">
                                    <label for="">Option 2</label>
                                    @if ($errors->has('option_2'))
                                        <strong>{{ $errors->first('option_2') }}</strong>
                                    @endif
                                    <input type="text" required="required" name="option_2"
                                        placeholder="Enter Option 2" class="form-control" value="{{ old('option_2') }}">
                                </div>
                            </div>

                            <div class="span5">
                                <div class="form-group">
                                    <label for="">Option 3</label>
                                    @if ($errors->has('option_3'))
                                        <strong>{{ $errors->first('option_3') }}</strong>
                                    @endif
                                    <input type="text" name="option_3"
                                        placeholder="Enter  Option 3" class="form-control"
                                        value="{{ old('option_3') }}">
                                </div>
                            </div>

                            <div class="span5">
                                <div class="form-group">
                                    <label for="">Option 4</label>
                                    @if ($errors->has('option_4'))
                                        <strong>{{ $errors->first('option_4') }}</strong>
                                    @endif
                                    <input type="text" name="option_4"
                                        placeholder="Enter  Option 4" class="form-control"
                                        value="{{ old('option_4') }}">
                                </div>
                            </div>

                            <div class="span12">
                                <div class="form-group">
                                    <label for="">Select a correct option</label>
                                    @if ($errors->has('ans'))
                                        <strong>{{ $errors->first('ans') }}</strong>
                                    @endif
                                    <select class="form-control" required="required" name="ans">
                                        <option value="">Select</option>
                                        <option value="option_1" {{ old('ans') == 'option_1' ? 'selected' : '' }}>option 1
                                        </option>
                                        <option value="option_2" {{ old('ans') == 'option_2' ? 'selected' : '' }}>option 2
                                        </option>
                                        <option value="option_3" {{ old('ans') == 'option_3' ? 'selected' : '' }}>option 3
                                        </option>
                                        <option value="option_4" {{ old('ans') == 'option_4' ? 'selected' : '' }}>option 4
                                        </option>
                                    </select>
                                </div>
                            </div>
							
							<div class="span12">
                                <div class="form-group">
                                    <label for="">Image</label>
                                    @if ($errors->has('image'))
                                        <strong>{{ $errors->first('image') }}</strong>
                                    @endif
                                    <input type="file" name="image" id="image"
                                        class="form-control image-box" />
                                </div>
                            </div>

                            <div class="span12">
                                <div class="form-group">
                                    <button class="btn btn-primary">Add</button>
                                </div>
                            </div>
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
		
		.image-box {
            margin-bottom: 8px;
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

        function questionDelete(id) {
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
                            url: '{{ url('admin/question/question-destroy') }}',
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
    </script>
@endsection
