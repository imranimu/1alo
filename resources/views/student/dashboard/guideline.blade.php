@extends('layouts.student.layer')
@section('title', 'Dashboard | Driving School')
@section('content')

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container bg-white py-3">

            <div style="min-height:400px">

                <div class="row">
                    @if (!blank($get_guideline))
                        @foreach ($get_guideline as $val)
                            <h5>{{ $val->title }}</h5>
                            {!! $val->description !!}
                            <br />
                        @endforeach
                    @endif
                </div>


            </div>
        </div>
    </div>
@endsection
