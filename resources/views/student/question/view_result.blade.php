@extends('layouts.student.layer')
@section('title', 'Join Exam | Driving School')
@section('content')

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container bg-white py-3">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="wrap wrap-content">
                        <h3 class="text-left">Result Details</h3>
						
                        <hr>
						
						<div class="row mb-3">
							<div class="col-md-6 CourseAnsInfo">
								<p>
									<span><strong>Courses Name : </strong> {{ $getReuslt->title }}</span> | 
									<span><strong>Module : </strong> {{ $getReuslt->module_name }}</span>
								</p>
								<p>
									<span><strong>Correst ans : </strong> {{ $getReuslt->yes_ans }}</span> | 
									<span><strong>Wrong ans : </strong> {{ $getReuslt->no_ans }}</span> | 
									<span><strong>Total : </strong> {{ $getReuslt->total_question }}</span>
								</p>	
								<p><span><strong>Pass Mark : </strong> 70% out of 100%</span></p>
							</div>
							@if ($getReuslt->question_percentage <= 69)
								<div class="col-md-6 text-right">
									<a class="btn btn-base" href="{{ url('/student/join-exam/'.$id) }}">Retake</a>
								</div>	
							@endif
						</div>
						<hr>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="wrap wrap-content">
                        @php $getAnsQues = json_decode($getReuslt->result_json); @endphp
                        @if (!blank($getAnsQues))
                            <ul class="list-unstyled text-left resultLists">
                                @php $count = 1 @endphp
                                @foreach ($getAnsQues as $val)
                                    @php
                                        $badges = 'badge badge-danger';
										$AnsStatus = 'alert alert-danger';
                                        $icon = '<i class="fa fa-close wrongAns"></i>';
                                        if ($val->currect_ans == $val->select_ans):
                                            $badges = 'badge badge-success';
											$AnsStatus = 'alert alert-success';
                                            $icon = '<i class="fa fa-check correctAns"></i>';
                                        endif;
                                    @endphp
                                    <li class="{{$AnsStatus}}"><span>{{ $count }}. {{ $val->question }} </span> <span class="{{ $badges }}">
                                            Ans:
                                            {{ $val->select_ans }}</span> <span>{!! $icon !!}</span></li>
                                    @php $count++ @endphp
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
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
		
		.CourseAnsInfo{
			text-align: left;
			width: 49%;
		}
		
		.CourseAnsInfo p{
			margin-bottom: 3px;
		}
		
		.resultLists{}
		
		.resultLists li{
			border: 1px solid #ccc;
			border-radius: 10px;
			padding: 5px 20px;
			margin-bottom: 15px;
		}
		
		.resultLists li span:nth-child(1), .resultLists li span:nth-child(2){
			margin-right: 10px;
		}
		.resultLists li span:nth-child(2){
			font-size: 14px;
		}
		.resultLists li span:nth-child(3){
			
		}
    </style>
@endsection
