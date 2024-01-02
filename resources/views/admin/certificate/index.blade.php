@extends('layouts.admin.layer')
@section('title', 'Certificate | Driving School')
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
            <li class="active">Certificate</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">

        <div class="row-fluid">
            <div class="table-header">
                Results for "Certificate List"
                <span class="text-muted pull-right show-count">Showing
                    {{ $records->currentPage() * $records->perPage() - $records->perPage() + 1 }} to
                    {{ $records->currentPage() * $records->perPage() > $records->total() ? $records->total() : $records->currentPage() * $records->perPage() }}
                    of {{ $records->total() }} data(s)</span>
            </div>

            <div class="search-box pull-right">
                <form action="{{ url('admin/certificate') }}" method="get">
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
                            <td>{{ ucwords($val->get_user->first_name) }} {{ ucwords($val->get_user->last_name) }}</td>
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
                            <td><a href="{{ url('admin/get-certificate/' . $val->id . '/'.$val->student_id.'/download') }}" target="_blank" class="badge badge-primary">Download</a></td>
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
	<div class="modal fade" id="modalError" tabindex="-1" role="dialog"
		aria-labelledby="modalError" aria-hidden="true">
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
