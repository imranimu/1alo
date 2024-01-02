@extends('layouts.admin.layer')
@section('title', 'Payment Lists | Driving School')
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
            <li class="active">Payment Lists</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>Payment Lists</h1>
        </div>
        <!--/.page-header-->

        <div class="row-fluid">
            <div class="table-header">
                Results for "Payment Lists"
                <span class="text-muted pull-right show-count">Showing
                    {{ $records->currentPage() * $records->perPage() - $records->perPage() + 1 }} to
                    {{ $records->currentPage() * $records->perPage() > $records->total() ? $records->total() : $records->currentPage() * $records->perPage() }}
                    of {{ $records->total() }} data(s)</span>
            </div>

            <div class="search-box pull-right">
                <form action="{{ url('admin/content/show') }}" method="get">
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
                        <th class="hidden-480">Student Name</th>
                        <th class="hidden-480">Course Name</th>
                        <th class="hidden-480">Total Amount</th>
                        <th class="hidden-480">Grand Amount</th>
                        <th class="hidden-480">transaction_id</th>
                        <th class="hidden-480">Addons</th>
                        <th class="hidden-480">status</th>
                        <th>Created at</th>
                    </tr>
                </thead>

                <tbody>
                    @php $count = 1; @endphp
                    @forelse($records as $val)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $val->get_user->first_name }}</td>
                            <td>{{ !blank($val->get_course) ? $val->get_course->title : '' }}</td>
							<td>{{ $val->total_amount }}</td>
                            <td>{{ $val->grand_amount }}</td>
                            <td>{{ $val->transaction_id }}</td>
                            <td>
                                @php
                                    if (!blank($val->get_addons)):
                                        echo '<a href="javascript:void(0)" onclick="addOns(' . $val->id . ')">Addons History</a>';
                                    endif;
                                @endphp
                            </td>
                            <td>{!! $val->payment_status == '1'
                                ? '<span class="badge badge-success">Confirm</span>'
                                : '<span class="badge badge-danger">Pending</span>' !!}</td>
                            <td>{{ $val->created_at }}</td>
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
        <!-- Modal -->
        <div class="modal fade" id="addonsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Addons History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="bodyBox">

                    </div>
                </div>
            </div>
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

        .trash {
            background: red !important
        }
    </style>

    <script>
        function addOns(id) {
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/payment/get-addons-history') }}',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    //console.log(response.data.length);
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    if (response.status == 2) {
                        toastr.error(response.text);
                    } else if (response.status == '1') {
                        let html = '';
                        html += '<table class="table table-bordered">' +
                            '<thead>' +
                            '<tr>' +
                            '<th scope="col">#SL</th>' +
                            '<th scope="col">Name</th>' +
                            '<th scope="col">Amount</th>' +
                            '<th scope="col">Created at</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';
                        '<tr>';
                        for (let i = 0; i < response.data.length; i++) {
                            html += '<th scope="row">' + (i + 1) + '</th>' +
                                '<td>' + response.data[i].name + '</td>' +
                                '<td>' + response.data[i].amount + '</td>' +
                                '<td>' + response.data[i].created_at + '</td>' +
                                '</tr>';
                        }
                        html += '</tbody>' +
                            '</table>';
                        $('#bodyBox').html(html);
                        $('#addonsModal').modal('show');
                    } else {
                        toastr.error(response.text);
                    }
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
