@extends('layouts.student.layer')
@section('title', 'Dashboard | Driving School')
@section('content')

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">        
        <div class="container bg-white py-3"> 
            <div class="row mb-3"> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"> 
                    <ul id="main-navigation">
                        <li><a class="active" href="{{ url('student/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>                        
                        <li><a href="{{ url('student/quiz') }}"><i class="fa fa-file"></i>&nbsp;Quiz/Test</a></li>                         
                        <li><a href="{{ url('/student/document') }}"><i class="fa fa-files-o"></i> Documents</a></li>
                        <li><a href="{{ url('/student/certificate') }}"><i class="fa fa-bars"></i>&nbsp;Certificate</a></li>
                    </ul>
                </div> 
            </div>

            <a href="{{ url('student/dashboard') }}" class="btn btn-primary btn-sm mb-4"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>  
            
            <div style="min-height:400px">

                <div class="alert alert-primary">
                    <h5 class="mb-0">Your logged course time is : {{ $diff_day_number }}</h5>
                </div>
                
                <div class="alert alert-secondary">
                    <h5 class="mb-0">You've completed: {{ $getTotalCourseModule !="" ? $getTotalCourseModule->total_module : 0 }} Module(s) of {{ $getTotalModuleComplete != '' ? $getTotalModuleComplete->total_lession : 0 }} Module(s).</h5>
                </div> 
                
                <div class="alert alert-warning" role="alert">
                    <h5>Reminder</h5> 
                    <p>To successfully pass this course you must meet the minimum time requirement and pass all quizzes and tests.</p>
                </div>

                
            </div>
        </div>
    </div>
@endsection
