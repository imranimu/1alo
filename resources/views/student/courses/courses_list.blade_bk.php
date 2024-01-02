@extends('layouts.student.layer')
@section('title', 'Courses Lists | Driving School')
@section('content')

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container bg-white py-3">
			@include('layouts/student/top_navbar')
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="wrap wrap-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#SL</th>
                                    <th scope="col">Courses Name</th>
									<th scope="col">Total Module</th>
									<th scope="col">Module Complete</th>
                                    <th scope="col">Courses Progress</th>
                                    <th scope="col">Payment Details</th>
									<th scope="col">Payment Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!blank($records))
                                    @php $count = 1; @endphp
                                    @foreach ($records as $val)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $val->get_course->title }}</td>
											<td>{{ $val->total_module }}</td>
											<td>{{ getModuleCompleted($val->course_id) }}</td>
                                            <td>
                                                {{ getCoursePercetage($val->course_id) }}%
                                            </td>
											<td><a href="javascript:void(0)" class="badge badge-success" onclick="paymentShow({{$val->id}})">History</a></td>
											<td>
                                                @if ($val->payment_status == 1 && $val->status == 1)
                                                    <label class="badge badge-success">Confirm</label>
                                                @else
                                                    <label class="badge badge-secondary">Pending</label>
                                                @endif
                                            </td>
											 @php
                                                $lession = DB::table('course_lessons')
                                                    ->where(['course_id' => $val->course_id, 'module_id' => $val->module_id])
													->whereRaw('deleted_at is null')
                                                    ->orderBy('id')
                                                    ->first();
                                            @endphp
                                            <td>
											@if (!blank($lession))
												<a href="{{ url('/student/course/' . $val->course_id . '/' . $val->module_id . '/' . $lession->id . '/2') }}"
													class="btn btn-primary ">Start</a>
											@else 
												-
											@endif
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
                    </div>
                </div>
            </div>
        </div>
		<!-- Modal -->
        <div class="modal fade" id="addonsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Payment History</h5>
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
	<script>
	function paymentShow(id) {
		$.ajax({
			type: 'POST',
			url: '{{ url('student/payment/get-payment-history') }}',
			data: {
				"id": id,
				"_token": "{{ csrf_token() }}"
			},
			success: function(response) {
				console.log(response);

				let html = '';
				html += '<table class="table table-bordered">' +
					'<thead>' +
					'<tr>' +
					'<th scope="col">Courses Name</th>' +
					'<th scope="col">Amount</th>' +
					'<th scope="col">Transaction ID</th>' +
					'<th scope="col">Purchase Date</th>' +
					'</tr>' +
					'</thead>' +
					'<tbody>'+
					'<tr>'+
					'<td>' + response.get_course.title + '</td>' +
					'<td>' + response.total_amount + '</td>' +
					'<td>' + response.transaction_id + '</td>' +
					'<td>' + response.created_at + '</td>' +
					'</tr>';
					'</tbody>' +
				'</table>';
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
				if (response.get_addons.length > 0) {
					for (let i = 0; i < response.get_addons.length; i++) {
						html += '<th scope="row">' + (i + 1) + '</th>' +
							'<td>' + response.get_addons[i].name + '</td>' +
							'<td>' + response.get_addons[i].amount + '</td>' +
							'<td>' + response.get_addons[i].created_at + '</td>' +
							'</tr>';
					}
				} else {
					html += '<td colspan="4">No Addons Found!</td></tr>'
				}
				html += '</tbody>' +
					'</table>';
				$('#bodyBox').html(html);
				$('#addonsModal').modal('show');

			}
		});
	}
	</script>
@endsection
