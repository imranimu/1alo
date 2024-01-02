@extends('layouts.admin.layer')

@section('title', 'Admin Lists | Driving School')

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
            <li class="active">Admin Lists</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative clearfix">
            <div class="span10 header-title">
                <h1>Admin Lists</h1>
            </div>
            <div class="span3 btn-user">
                <a href="{{ url('/admin/user/add-user') }}" class="btn btn-primary">Create User</a>
            </div>
        </div>
        <!--/.page-header-->

        <div class="row-fluid">
            <div class="table-header">
                Results for "Admin Lists"
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

            <table id="sample-table-2" class="table table-striped table-bordered table-hover notice-table">
                <thead>
                    <tr>
                        <th class="hidden-480">ID</th>
                        <th class="hidden-480">Name</th>
                        <th class="hidden-480">Mobile</th>
                        <th class="hidden-480">Email</th>
                        <th class="hidden-480">Role</th>
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
                            <td>{{ $val->first_name . ' ' . $val->last_name }}</td>
                            <td>{{ $val->mobile_no }}</td>
                            <td>{{ $val->email }}</td>
                            <td>
                                @if ($val->is_role == 1)
                                    <span class="badge badge-success">Admin</span>
                                @else
                                    <span class="badge badge-success">Other</span>
                                @endif
                            </td>
                            <td>{!! $val->status == 1
                                ? '<span class="badge badge-success">Active</span>'
                                : '<span class="badge badge-danger">Inactive</span>' !!}</td>

                            <td>{{ $val->created_at }}</td>
                            <td>
                                <a class="badge badge-info" href="{{ url('admin/user/' . $val->id . '/edit') }}"
                                    data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="badge badge-warning" href="{{ url('admin/user/' . $val->id . '/password') }}"
                                    data-toggle="tooltip" title="Change Password">
                                    <i class="fa fa-lock"></i>
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
    </style>
@endsection
