@extends('layouts.admin.layer')
@section('title', 'Question Lists | Driving School')
@section('content')


    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="#">Home</a>
                <span class="divider">
                    <i class="icon-angle-right arrow-icon"></i>
                </span>

            </li>
            <li class="active">Student Report Lists</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative clearfix">
            <div class="span10 header-title">
                <h1>Student Report</h1>
            </div>
        </div>
        <!--/.page-header-->

        <div class="row-fluid">
            <div class="table-header">
                Results for "Student Report"
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
                        <th scope="col">#SL</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Student email</th>
                        <th scope="col">Courses Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if (!blank($records))
                        @php $count = 1; @endphp
                        @foreach ($records as $val)
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ isset($val->get_user) ? $val->get_user->first_name.' '.$val->get_user->last_name : '' }}</td>
                                <td>{{ isset($val->get_user) ? $val->get_user->email : '' }}</td>
                                <td>{{ isset($val->get_course) ? $val->get_course->title : '' }}</td>
                                <td>
                                    <a href="{{ url('/admin/report/' . $val->course_id . '/' . $val->student_id . '/download') }}"
                                        class="btn btn-primary ">Download</a>
                                </td>
                            </tr>
                            @php $count++; @endphp
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">No Courses Found!</td>
                        </tr>
                    @endif
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
@endsection
