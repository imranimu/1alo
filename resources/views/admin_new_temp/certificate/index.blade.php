@extends('layouts.admin.layer')
@section('title', 'Certificate | Driving School')
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
                        <li class="breadcrumb-item active">Certificate</li>
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
                    <h4 class="card-title mb-0 flex-grow-1">Certificate Lists</h4>
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
                            <form action="{{ url('admin/certificate') }}" method="get">
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
                                        <th class="hidden-480">#SL</th>
                                        <th class="hidden-480">Student Name</th>
                                        <th class="hidden-480">Courses Name</th>
                                        <th class="hidden-480">Type</th>
                                        <th class="hidden-480">Certificate (PDF)</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @forelse($records as $val)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ ucwords($val->get_user->first_name) }}
                                                {{ ucwords($val->get_user->last_name) }}</td>
                                            <td>{{ getCourseName($val->course_id) }}</td>
                                            <td>
                                                @if ($val->is_type == 'C1')
                                                    <label class="badge bg-info">Certificate first part</label>
                                                @elseif ($val->is_type == 'C2')
                                                    <label class="badge bg-info">Certificate second part</label>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td><a href="{{ url('admin/get-certificate/' . $val->id . '/' . $val->student_id . '/download') }}"
                                                    target="_blank" class="badge bg-primary">Download</a></td>
                                            <td>{{ date('d-m-Y', strtotime($val->created_at)) }}</td>
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
    <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalError" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
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
    @php $getCertificateErrorMessage = Session::get('getCertificateErrorMessage'); @endphp
    <script>
        let message = '';
        @if (isset($getCertificateErrorMessage) &&
                $getCertificateErrorMessage['status'] == '0' &&
                $getCertificateErrorMessage['type'] == '1')
            let url = '{{ url('/') }}';
            message += '<p>{{ $getCertificateErrorMessage['message'] }}</p>';
            $('#modal_body').html(message);
            $('#modalError').modal('show');
        @elseif (isset($getCertificateErrorMessage) &&
                $getCertificateErrorMessage['status'] == '0' &&
                $getCertificateErrorMessage['type'] == '2')
            message += '<p>{{ $getCertificateErrorMessage['message'] }}</p>';
            $('#modal_body').html(message);
            $('#modalError').modal('show');
        @endif
    </script>
    <style>
        .wrap.wrap-content {
            background: #fff;
            padding: 22px;
        }

        .wrap-content h3 {
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
    </style>
    @php Session::forget('getCertificateErrorMessage'); @endphp
@endsection
