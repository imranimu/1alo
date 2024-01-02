@extends('layouts.student.layer')
@section('title', 'Dashboard | Driving School')
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
                                    <th scope="col">Exam Title</th>
                                    <th scope="col">Courses Name</th>
                                    <th scope="col">Module</th>
                                    <th scope="col">Exam Status</th>
									<th scope="col">Exam Percentage</th>
                                    <th scope="col">Result</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!blank($records))
                                    @php $count = 1; @endphp
                                    @foreach ($records as $val)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $val->title }}</td>
                                            <td>{{ $val->courses_name }}</td>
                                            <td>{{ $val->module_name }}</td>
                                            <td>{{ $val->exam_status == '2' ? 'Finished' : 'Pending' }}</td>
                                            <td>{{ $val->exam_percentage }}%</td>
                                            <td>
                                                @if ($val->exam_status == '2')
                                                   <a href="{{ url('/student/view-result/' . $val->exam_id) }}"
                                                        class="badge badge-success">View
                                                        Result</a>
												@elseif ($val->exam_status == '1')		
													<a href="{{ url('/student/view-result/' . $val->exam_id) }}"
                                                        class="badge badge-danger">View
                                                        Result</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($val->exam_status == '2' && $val->completed_at != '')
                                                    -
                                                @else
													{{-- @if (getExamStart($val->id, $val->courses_id)) --}}
                                                        <a href="{{ url('student/join-exam/' . $val->exam_id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            {{ $val->exam_status == '1' ? 'Retake' : 'Start Exam' }}
                                                        </a>
													{{-- @else
                                                        <label disabled>Exam Processing</label>
                                                    @endif --}}
                                                @endif
                                            </td>
                                        </tr>
                                        @php $count++; @endphp
                                    @endforeach
								@else
									<tr>
										<td colspan="8">No Courses Exam Found!</td>
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
    </div>
@endsection
