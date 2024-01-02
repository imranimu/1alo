@extends('layouts.student.layer')
@section('title', 'Dashboard | Driving School')
@section('content')

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">        
        <div class="container bg-white py-3"> 
            <div class="row mb-3"> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"> 
                    <ul id="main-navigation">
                        <li><a href="{{ url('/student/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>                        
                        <li><a href="{{ url('/student/quiz') }}" class="active"><i class="fa fa-file"></i>&nbsp;Quiz/Test</a></li>                         
                        <li><a href="{{ url('/student/document') }}"><i class="fa fa-files-o"></i> Documents</a></li>
                        <li><a href="{{ url('/student/certificate') }}"><i class="fa fa-bars"></i>&nbsp;Certificate</a></li>
                    </ul>
                </div> 
            </div>

            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>  
            
        </div>
    </div>
@endsection
