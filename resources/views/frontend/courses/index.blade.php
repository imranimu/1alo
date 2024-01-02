@extends('layouts.frontend.layer')
@section('title', 'Courses | Drive Safe')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-area" style="background-image:url('{{ asset('assets/frontend/img/other/3.png') }}')">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="section-title mb-0">
                    <h2 class="page-title">Courses</h2>
                    <ul class="page-list">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Courses</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container">
            <div class="row justify-content-start">
                @forelse($records as $val)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-course-inner">
                            <div class="thumb">
                                @if ($val->image != '')
                                    <img src="{{ asset('storage/app/public/image/course/thumbnail/' . $val->image) }}" alt="img">
                                @endif
                                <div class="course-header-meta">
                                    <span class="price">{{ $val->price != '' ? '$' . $val->price : '' }}</span>
                                </div>
                            </div>
                            <div class="details-inner">
                                <div class="course-meta">
                                    <div class="row">
                                        <div class="col-6">
                                            <img src="{{ asset('assets/frontend/img/course/1.png') }}" alt="img">
                                            {{ $val->course_level }}
                                        </div>
                                        <div class="col-6 text-right">
                                            <img src="{{ asset('assets/frontend/img/course/2.png') }}" alt="img">
                                            {{ $val->course_duration != '' ? $val->course_duration . ' Week' : '' }}
                                        </div>
                                    </div>
                                </div>
                                <h4><a href="{{ url('courses/' . $val->slug) }}">{{ $val->title }}</a></h4>
                                @php
                                    $description = str_replace('<p>', '', substr($val->description, 0, 55));
                                @endphp
                                <p>{{ $description }}</p>
                                <div class="course-footer">
                                    <div class="row">
                                        <div class="col-12 align-self-center text-right">
                                            <a class="read-more-text" href="{{ url('courses/' . $val->slug) }}">Read More
                                                <i class="la la-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p colspan="7">No Data Found</p>
                    </tr>
                @endforelse
            </div>

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
    <!-- course area end -->

@endsection
