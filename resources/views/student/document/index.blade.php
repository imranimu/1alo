@extends('layouts.student.layer')
@section('title', 'Document Lists | Driving School')
@section('content')

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container  bg-white py-3">
			@include('layouts/student/top_navbar')
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="wrap wrap-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-left">
                                    <th scope="col">#SL</th>
                                    <th scope="col">Courses Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!blank($records))
                                    @php $count = 1; @endphp
                                    @foreach ($records as $val)
                                        <tr class="text-left">
                                            <td>{{ $count }}</td>
                                            <td>
                                                @if ($val->course_id > 0)
                                                    {{ getCourseName($val->course_id) }}
                                                @else
                                                    All
                                                @endif
                                            </td>
                                            <td>{{ $val->title }}</td>
                                            <td><a href="{{ asset('storage/app/public/document/' . $val->file) }}" target="_blank"
                                                    class="badge badge-primary">Download</a></td>
                                        </tr>
                                        @php $count++; @endphp
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No Data Found!</td>
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
@endsection
