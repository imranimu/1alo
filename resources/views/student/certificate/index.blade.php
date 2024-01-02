@extends('layouts.student.layer')
@section('title', 'Certificate Lists | Driving School')
@section('content')
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container bg-white py-3">
            @include('layouts/student/top_navbar')
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="wrap wrap-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-left">
                                    <th scope="col">#SL</th>
                                    <th scope="col">Courses Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Certificate (PDF)</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!blank($records))
                                    @php $count = 1; @endphp
                                    @foreach ($records as $val)
                                        <tr class="text-left">
                                            <td>{{ $count }}</td>
                                            <td>{{ getCourseName($val->course_id) }}</td>
                                            <td>
                                                @if ($val->is_type == 'C1')
                                                    <label class="badge badge-info">Certificate first part</label>
                                                @elseif ($val->is_type == 'C2')
                                                    <label class="badge badge-info">Certificate second part</label>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td><a href="{{ url('student/get-certificate/' . $val->id . '/download') }}"
                                                    class="badge badge-primary">Download</a></td>
                                            <td>{{ date('d-m-Y', strtotime($val->created_at)) }}</td>
                                        </tr>
                                        @php $count++; @endphp
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No Certificate Found!</td>
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
            </div>
        </div>

        <div class="modal" id="modalError" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Warning</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal_body">

                    </div>
                </div>
            </div>
        </div>

    </div>
    @php $getCertificateErrorMessage = Session::get('getCertificateErrorMessage'); @endphp
    <script>
        let message = '';
        @if (isset($getCertificateErrorMessage) &&
                $getCertificateErrorMessage['status'] == '0' &&
                $getCertificateErrorMessage['type'] == '1')
            let url = '{{ url('/') }}';
            message += '<p>{{ $getCertificateErrorMessage['message'] }}</p>' +
                '<a href="' + url + '/student/modify-address' + '" class="btn btn-danger btn-update">Update</a>';
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
