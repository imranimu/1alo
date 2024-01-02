@extends('layouts.admin.layer')
@section('title', 'Payment Lists | Driving School')
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
                        <li class="breadcrumb-item active">Payment Lists</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Payment Lists</h4>
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
                            <form action="{{ url('admin/payment/show') }}" method="get">
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
                                                        echo '<a href="javascript:void(0)" class="badge bg-info" onclick="addOns(' . $val->id . ')">Addons History</a>';
                                                    endif;
                                                @endphp
                                            </td>
                                            <td>{!! $val->payment_status == '1'
                                                ? '<span class="badge bg-success">Confirm</span>'
                                                : '<span class="badge bg-danger">Pending</span>' !!}</td>
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

    <!-- Modal -->
    <div class="modal fade" id="addonsModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Addons History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="bodyBox">

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
