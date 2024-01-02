@extends('layouts.student.layer')
@section('title', 'Join Exam | Driving School')
@section('content')

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container bg-white py-3">
            <div class="row">
                <div class="col-sm-6 courses-title">
                    <h3>Courses Name : {{ $getExamMaster->courses_name }}</h3>
                </div>
                <div class="col-sm-3  courses-title">
                    <h3><b>Module</b> : {{ $getExamMaster->module_name }}</h3>
                </div>

                <div class="col-sm-3  courses-title">
                    <h3><b>Status</b> : Running</h3>
                </div>
            </div>
            <hr>

            <div class="">
                <form action="{{ url('student/store-exam') }}" method="POST">
                    <input type="hidden" name="exam_id" value="{{ $id }}">
                    @csrf

                    @if (!blank($getQuestion))
                        @php $count = 0 @endphp
                        @foreach ($getQuestion as $val)
                            @php $options = json_decode($val->options,true); @endphp
                            <div class="col-lg-12 col-md-12">
                                <input type="hidden" value="{{ $val->id }}" name="question_id{{ $count + 1 }}">
                                <p>{{ $count + 1 }}. {{ $val->question }}</p>
                                <ul class="list-inline question-list">
									@if ($val->file != '')
                                        <li>
                                            <img src="{{ asset('storage/app/public/image/question/' . $val->file) }}"
                                                alt="question-image" style="width: 300px">
                                        </li>
                                    @endif
                                    <li>
										<label for="ans{{ $count + 1 }}_1">
											<input type="radio" value="{{ $options['option_1'] }}"
												name="ans{{ $count + 1 }}" id="ans{{ $count + 1 }}_1">
											{{ $options['option_1'] }}
										</label>
                                    </li>
                                    <li>
										<label for="ans{{ $count + 1 }}_2">
											<input type="radio" value="{{ $options['option_2'] }}"
												name="ans{{ $count + 1 }}" id="ans{{ $count + 1 }}_2">
											{{ $options['option_2'] }}
										</label>
                                    </li>
									@if ($options['option_3'] != null)
										<li>
											<label for="ans{{ $count + 1 }}_3">
												<input type="radio" value="{{ $options['option_3'] }}"
													name="ans{{ $count + 1 }}" id="ans{{ $count + 1 }}_3">
												{{ $options['option_3'] }}
											</label>
										</li>
									@endif
                                    @if ($options['option_4'] != null)
										<li>
											<label for="ans{{ $count + 1 }}_4">
												<input type="radio" value="{{ $options['option_4'] }}"
													name="ans{{ $count + 1 }}" id="ans{{ $count + 1 }}_4">
												{{ $options['option_4'] }}
											</label>
										</li>
									@endif
                                </ul>
                            </div>
                            @php $count++ @endphp
                        @endforeach
                    @endif
                    <input type="hidden" value="{{ $count }}" name="total_question">
                    <div class="col-lg-12 col-md-12">
                        <button type="submit" class="btn btn-primary" id="myCheck">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <style>
        .question-list {
            margin-left: 18px;
        }
		
		.courses-title h3 {
            font-size: 18px;
        }
    </style>
@endsection
